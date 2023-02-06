<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountUse;
use App\Models\Wheel;
use App\Models\Snapshot;
use App\Models\Coupon;
use App\Models\SnapshotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountController extends Controller
{

    public function shows(Request $request)
    {
        $page = $request->query('page', 1);
        $sort = $request->query('sort', 'created_at');
        $search = $request->query('search', '');
        $account_per_page = 30.0;
        $accounts = Account::leftJoin('snapshots', 'snapshots.account_id', '=', 'accounts.id')
            ->leftJoin('coupons', 'coupons.snapshot_id', '=', 'snapshots.id')
            ->where('coupons.ending_at', '>', DB::raw('NOW()'))->orWhereNull('coupons.ending_at')
            ->where('accounts.mail', 'like', '%' . $search . '%')
            ->orWhere('accounts.qr_code', 'like', '%' . $search . '%')
            ->orWhere('accounts.password', 'like', '%' . $search . '%')
            ->orWhere('snapshots.points', 'like', '%' . $search . '%')
            ->select('accounts.id', 'accounts.mail', 'password', 'qr_code', DB::raw('IFNULL(points, \'...\') as points'), DB::raw('count(coupons.id) as coupons'))
            ->groupBy('accounts.id', 'accounts.mail', 'password', 'qr_code', 'points', 'created_at')
            ->orderByDesc($sort);

        $total = $accounts->get()->count();
        $rows = $accounts->skip(($page - 1) * $account_per_page)->take($account_per_page)->get()->toArray();
        foreach ($rows as $key => $row) {
            $rows[$key]['actions'] = [
                'Afficher' => [
                    'url' => route('accounts.show', ['account' => $row['id'], 'tab' => 'Informations']),
                ],
                'QR Code' => [
                    'url' => Account::find($row['id'])->qr_link(),
                ],
                'Supprimer' => [
                    'url' => route('accounts.show', ['account' => $row['id'], 'tab' => 'Informations']),
                ],
            ];

            unset($rows[$key]['id']);
        }

        return view('accounts.shows', [
            'filters' => [
                'Couronnes' => [
                    'url' => route('accounts.shows', ['sort' => 'points', 'page' => $page, 'search' => $search]),
                    'active' => $sort == 'points',
                ],
                'Coupons' => [
                    'url' => route('accounts.shows', ['sort' => 'coupons', 'page' => $page, 'search' => $search]),
                    'active' => $sort == 'coupons',
                ], 'Date de création' => [
                    'url' => route('accounts.shows', ['sort' => 'created_at', 'page' => $page, 'search' => $search]),
                    'active' => $sort == 'created_at',
                ]
            ],
            'search' => [
                'url' => route('accounts.shows'),
                'placeholder' => 'Rechercher un compte',
                'value' => $search,
            ],
            'total' => $total,
            'columns' => ['mail', 'password', 'qr_code', 'Couronnes', 'coupons'],
            'rows' => $rows,
            'pagination' => [
                'total' => ceil($total / $account_per_page),
                'current' => $page,
                'next' => [
                    'name' => 'Suivant',
                    'url' => route('accounts.shows', ['page' => min($page + 1, ceil($total / $account_per_page)), 'sort' => $sort, 'search' => $search]),
                ],
                'previous' => [
                    'name' => 'Précédent',
                    'url' => route('accounts.shows', ['page' => max($page - 1, 1), 'sort' => $sort, 'search' => $search]),
                ],
            ],
        ]);
    }

    public function add()
    {
        return view('accounts.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mail' => 'required|email|unique:accounts,mail',
            'password' => 'required',
            'qrcode' => 'required|min:6|max:6|unique:accounts,qr_code',
            'birthdate' => 'nullable|date',
            'hasKids' => 'nullable|boolean',
        ]);

        Account::create(
            [
                "mail" => $request->input('mail'),
                "password" => $request->input('password'),
                "qr_code" => $request->input('qrcode'),
                "user_id" => Auth::id(),
                "birth_date" => $request->input('birthdate'),
                "has_kids" => $request->input('hasKids')
            ]
        );

        return redirect()->route('accounts.shows')->with('success', ['title' => 'Compte créé', 'message' => 'Le compte a bien été créé.']);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
            'birthdate' => 'nullable|date',
            'hasKids' => 'nullable|boolean',
        ]);

        $account = Account::find($id);
        $account->password = $request->input('password');
        $account->birth_date = $request->input('birthdate');
        $account->has_kids = $request->input('hasKids', 0);
        $account->save();

        return redirect()->route('accounts.show', ['account' => $id])->with('success', ['title' => 'Compte modifié', 'message' => 'Le compte a bien été modifié.']);
    }

    // Une roue est disponible si aucune roue n'a été tournée depuis 2 semaines et si nous sommes dans la dernière semaine du mois (Nombre de jours dans le mois - 7)
    public function show(Request $request, $id, $tab)
    {
        $account = Account::find($id);
        $page = $request->query('page', 1);
        $search = $request->query('search', '');
        $rows_per_page = 30.0;

        $wheels = Wheel::where('account_id', $id)
            ->select('reward', 'user_id', 'catched_at')
            ->orderBy('catched_at', 'desc');
        if ($tab == 'Roulette') {
            $wheels->where('reward', 'like', '%' . $search . '%')
                ->orWhere('catched_at', 'like', '%' . $search . '%');
        }
        $totalWheels = $wheels->get()->count();
        $rowsWheels = $wheels->skip(($page - 1) * $rows_per_page)->take($rows_per_page)->get()->toArray();

        $coupons = Coupon::join('snapshots', 'snapshots.id', '=', 'coupons.snapshot_id')
            ->where('account_id', $id)
            ->select(DB::raw('coupons.id as coupon_id'), DB::raw('IF(ending_at < now(), "Expiré", "Disponible")'), 'label', 'description', 'ending_at')
            ->orderBy('ending_at', 'desc');
        if ($tab == 'Coupons') {
            $coupons->where('label', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('ending_at', 'like', '%' . $search . '%');
        }
        $totalCoupons = $coupons->get()->count();
        $rowsCoupons = $coupons->skip(($page - 1) * $rows_per_page)->take($rows_per_page)->get()->toArray();

        $snapshots = Snapshot::where('account_id', $id)
            ->join('coupons', 'coupons.snapshot_id', '=', 'snapshots.id')
            ->select('points', DB::raw('COUNT(coupons.id) as nb_coupons'), 'user_id', 'captured_at')
            ->groupBy('snapshots.id')
            ->orderBy('captured_at', 'desc');
        if ($tab == 'Snapshots') {
            $snapshots->where('points', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('captured_at', 'like', '%' . $search . '%');
        }
        $totalSnapshots = $snapshots->get()->count();
        $rowsSnapshots = $snapshots->skip(($page - 1) * $rows_per_page)->take($rows_per_page)->get()->toArray();

        $requestedSnapshots = SnapshotRequest::where('account_id', $id)
            ->select('priority', 'status', 'user_id', 'requested_at')
            ->orderBy('requested_at', 'desc');
        $totalRequestedSnapshots = $requestedSnapshots->get()->count();
        $rowsRequestedSnapshots = $requestedSnapshots->get()->toArray();

        $histories = AccountUse::where('account_id', $id)
            ->select('user_id', 'used_at')
            ->orderBy('used_at', 'desc');
        if ($tab == 'Historique') {
            $histories->where('used_at', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%');
        }
        $totalHistory = $histories->get()->count();
        $rowsHistory = $histories->skip(($page - 1) * $rows_per_page)->take($rows_per_page)->get()->toArray();

        return view('accounts.show', [
            'tab' => $tab,
            'account' => $account,
            'wheels' => [
                'available' => $wheels->where('catched_at', '>', Carbon::now()->subDays(14))->count() == 0 && Carbon::now()->day >= Carbon::now()->daysInMonth - 7,
                'total' => $totalWheels,
                'columns' => ['récompense', 'utilisateur', 'date'],
                'rows' => $rowsWheels,
                'search' => [
                    'url' => route('accounts.show', ['account' => $id, 'tab' => 'Roulette']),
                    'placeholder' => 'Rechercher une récompense',
                    'value' => $search,
                ],
                'pagination' => [
                    'total' => ceil($totalWheels / $rows_per_page),
                    'current' => $page,
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Roulette', 'page' => min($page + 1, ceil($totalWheels / $rows_per_page)), 'search' => $search]),
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Roulette', 'page' => max($page - 1, 1), 'search' => $search]),
                    ],
                ],
            ],
            'coupons' => [
                'total' => $totalCoupons,
                'columns' => ['id', 'status', 'label', 'description', 'expire le'],
                'rows' => $rowsCoupons,
                'search' => [
                    'url' => route('accounts.show', ['account' => $id, 'tab' => 'Coupons']),
                    'placeholder' => 'Rechercher un coupon',
                    'value' => $search,
                ],
                'pagination' => [
                    'total' => ceil($totalCoupons / $rows_per_page),
                    'current' => $page,
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Coupons', 'page' => min($page + 1, ceil($totalCoupons / $rows_per_page)), 'search' => $search]),
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Coupons', 'page' => max($page - 1, 1), 'search' => $search]),
                    ],
                ],
            ],
            'snapshots' => [
                'total' => $totalSnapshots,
                'columns' => ['points', 'nb coupons', 'utilisateur', 'date'],
                'rows' => $rowsSnapshots,
                'search' => [
                    'url' => route('accounts.show', ['account' => $id, 'tab' => 'Snapshots']),
                    'placeholder' => 'Rechercher un snapshot',
                    'value' => $search,
                ],
                'pagination' => [
                    'total' => ceil($totalSnapshots / $rows_per_page),
                    'current' => $page,
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Snapshots', 'page' => min($page + 1, ceil($totalSnapshots / $rows_per_page)), 'search' => $search]),
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Snapshots', 'page' => max($page - 1, 1), 'search' => $search]),
                    ],
                ],
            ],
            'requestedSnapshots' => [
                'total' => $totalRequestedSnapshots,
                'columns' => ['priorité', 'status', 'utilisateur', 'date'],
                'rows' => $rowsRequestedSnapshots,
            ],
            'histories' => [
                'total' => $totalHistory,
                'columns' => ['utilisateur', 'date'],
                'rows' => $rowsHistory,
                'search' => [
                    'url' => route('accounts.show', ['account' => $id, 'tab' => 'Historique']),
                    'placeholder' => 'Rechercher une utilisation',
                    'value' => $search,
                ],
                'pagination' => [
                    'total' => ceil($totalHistory / $rows_per_page),
                    'current' => $page,
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Historique', 'page' => min($page + 1, ceil($totalHistory / $rows_per_page)), 'search' => $search]),
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('accounts.show', ['account' => $id, 'tab' => 'Historique', 'page' => max($page - 1, 1), 'search' => $search]),
                    ],
                ],
            ],
        ]);
    }
}
