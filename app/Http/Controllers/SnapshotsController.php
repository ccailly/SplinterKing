<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Snapshot;
use App\Models\SnapshotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SnapshotsController extends Controller
{
    function shows(Request $request)
    {
        $snapshots_request_page = $request->query('snapshots_request_page', 1);
        $snapshots_request_per_page = 30.0;
        $snapshots_request = SnapshotRequest::leftJoin('accounts', 'accounts.id', '=', 'snapshot_requests.account_id')
            ->leftJoin('users', 'users.id', '=', 'snapshot_requests.user_id')
            ->select(
                DB::raw('snapshot_requests.id as snapshot_request_id'),
                DB::raw('accounts.id as account_id'),
                'accounts.mail',
                'priority',
                'status',
                DB::raw('IFNULL(users.name, "N/A") as user_name'),
                'requested_at'
            )
            ->whereIn('status', ['pending', 'processing'])
            ->orderByDesc('priority');
        $total_snapshots_request = $snapshots_request->get()->count();
        $rows_snapshots_request = $snapshots_request->skip(($snapshots_request_page - 1) * $snapshots_request_per_page)
            ->take($snapshots_request_per_page)->get()->toArray();

        foreach ($rows_snapshots_request as $key => $row) {
            $rows_snapshots_request[$key]['mail'] = '<a href="' . route('accounts.show', ['account' => $row['account_id'], 'tab' => 'Informations']) . '">' . $row['mail'] . '</a>';
            $rows_snapshots_request[$key]['actions'] = [
                'Modifier' => [
                    'url' => route('snapshots.requests.show', ['snapshot_request_id' => $row['snapshot_request_id']]),
                ],
                'Supprimer' => [
                    'url' => route('snapshots.requests.show', ['snapshot_request_id' => $row['snapshot_request_id'], 'delete' => true]),
                ],
            ];

            unset($rows_snapshots_request[$key]['snapshot_request_id']);
            unset($rows_snapshots_request[$key]['account_id']);
        }

        $snapshots_page = $request->query('snapshots_page', 1);
        $snapshots_sort = $request->query('sort', 'captured_at2');
        $snapshots_search = $request->query('search', '');
        $snapshots_per_page = 30.0;
        $snapshots = SnapshotRequest::leftJoin('accounts', 'accounts.id', '=', 'snapshot_requests.account_id')
            ->leftJoin('users', 'users.id', '=', 'snapshot_requests.user_id')
            ->leftjoin('snapshots', 'snapshots.snapshot_request_id', '=', 'snapshot_requests.id')
            ->leftjoin('coupons', 'coupons.snapshot_id', '=', 'snapshots.id')
            ->whereIn('snapshot_requests.status', ['completed', 'failed'])
            ->where(function ($query) use ($snapshots_search) {
                $query->where('accounts.mail', 'like', '%' . $snapshots_search . '%')
                    ->orWhere('users.name', 'like', '%' . $snapshots_search . '%')
                    ->orWhere('snapshot_requests.status', 'like', '%' . $snapshots_search . '%')
                    ->orWhere('snapshots.points', 'like', '%' . $snapshots_search . '%')
                    ->orWhere('snapshots.captured_at', 'like', '%' . $snapshots_search . '%');
            })
            ->select(DB::raw('accounts.id as account_id'), 'accounts.mail', 'users.name', 'snapshot_requests.status', DB::raw('IFNULL(points, 0)'), DB::raw('count(coupons.snapshot_id) as nb_coupons'), DB::raw('IFNULL(captured_at, snapshot_requests.updated_at) as captured_at2'))
            ->groupBy('snapshots.id', 'accounts.id', 'snapshots.points', 'snapshots.captured_at', 'accounts.mail', 'users.name', 'snapshot_requests.status', 'snapshot_requests.requested_at', 'snapshot_requests.updated_at')
            ->orderByDesc($snapshots_sort);

        $total_snapshots = $snapshots->get()->count();
        $rows_snapshots = $snapshots->skip(($snapshots_page - 1) * $snapshots_per_page)
            ->take($snapshots_per_page)->get()->toArray();

        foreach ($rows_snapshots as $key => $row) {
            $rows_snapshots[$key]['mail'] = '<a href="' . route('accounts.show', ['account' => $row['account_id'], 'tab' => 'Informations']) . '">' . $row['mail'] . '</a>';
            
            unset($rows_snapshots[$key]['account_id']);
        }

        return view('snapshots.shows', [
            'requestedSnapshots' => [
                'total' => $total_snapshots_request,
                'columns' => [
                    'Compte',
                    'Priorité',
                    'Statut',
                    'Utilisateur',
                    'Date de demande',
                    'actions'
                ],
                'rows' => $rows_snapshots_request,
                'pagination' => [
                    'current' => $snapshots_request_page,
                    'total' => ceil($total_snapshots_request / $snapshots_request_per_page),
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('snapshots.shows', ['sort' => $snapshots_sort, 'search' => $snapshots_search, 'snapshots_request_page' => min($snapshots_request_page + 1, ceil($total_snapshots_request / $snapshots_request_per_page)), 'snapshots_page' => $snapshots_page])
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('snapshots.shows', ['sort' => $snapshots_sort, 'search' => $snapshots_search, 'snapshots_request_page' => max($snapshots_request_page - 1, 1), 'snapshots_page' => $snapshots_page])
                    ]
                ]
            ],
            'snapshots' => [
                'total' => $total_snapshots,
                'columns' => [
                    'Compte',
                    'Utilisateur',
                    'Status',
                    'Points',
                    'Nombre de coupons',
                    'Date de capture'
                ],
                'rows' => $rows_snapshots,
                'pagination' => [
                    'current' => $snapshots_page,
                    'total' => ceil($total_snapshots / $snapshots_per_page),
                    'next' => [
                        'name' => 'Suivant',
                        'url' => route('snapshots.shows', ['sort' => $snapshots_sort, 'search' => $snapshots_search, 'snapshots_page' => min($snapshots_page + 1, ceil($total_snapshots / $snapshots_per_page)), 'snapshots_request_page' => $snapshots_request_page])
                    ],
                    'previous' => [
                        'name' => 'Précédent',
                        'url' => route('snapshots.shows', ['sort' => $snapshots_sort, 'search' => $snapshots_search, 'snapshots_page' => max($snapshots_page - 1, 1), 'snapshots_request_page' => $snapshots_request_page])
                    ]
                ],
                'filters' => [
                    'Points' => [
                        'url' => route('snapshots.shows', ['sort' => 'points']),
                        'active' => $snapshots_sort == 'points'
                    ],
                    'Date de capture' => [
                        'url' => route('snapshots.shows', ['sort' => 'captured_at']),
                        'active' => $snapshots_sort == 'captured_at'
                    ],
                    'Nombre de coupons' => [
                        'url' => route('snapshots.shows', ['sort' => 'nb_coupons']),
                        'active' => $snapshots_sort == 'nb_coupons'
                    ]
                ],
                'search' => [
                    'url' => route('snapshots.shows', ['search' => $snapshots_search]),
                    'placeholder' => 'Rechercher une snapshot',
                    'value' => $snapshots_search
                ]
            ]
        ]);
    }

    function add(Request $request)
    {
        $accountId = $request->query('accountId', null);
        $accounts = Account::all();
        $priorities = ['low', 'normal', 'high', 'urgent'];

        return view('snapshots.requests.add', ['accountId' => $accountId, 'accounts' => $accounts, 'priorities' => $priorities]);
    }

    function store(Request $request)
    {
        $request->validate([
            'account' => 'required|exists:accounts,id',
            'priority' => 'required|in:low,normal,high,urgent'
        ]);

        if (SnapshotRequest::where('account_id', $request->input('account'))
            ->whereIn('status', ['pending', 'processing'])
            ->exists()
        ) {
            return redirect()->route('snapshots.shows')->with('error', ['title' => 'Erreur', 'message' => 'Une demande de snapshot existe déjà pour ce compte.']);
        }

        $snapshot_request = new SnapshotRequest();
        $snapshot_request->account_id = $request->input('account');
        $snapshot_request->priority = $request->input('priority');
        $snapshot_request->user_id = Auth::user()->id;
        $snapshot_request->save();

        return redirect()->route('snapshots.shows')->with('success', ['title' => 'Succès', 'message' => 'La demande de snapshot a bien été créée.']);
    }

    function edit(Request $request, $snapshot_request_id)
    {
        $request->validate([
            'priority' => 'required|in:low,normal,high,urgent'
        ]);

        $snapshot_request = SnapshotRequest::find($snapshot_request_id);
        $snapshot_request->priority = $request->input('priority');
        $snapshot_request->save();

        return redirect()->route('snapshots.shows')->with('success', ['title' => 'Succès', 'message' => 'La demande de snapshot a bien été modifiée.']);
    }

    function delete($snapshot_request_id)
    {
        $snapshot_request = SnapshotRequest::find($snapshot_request_id);
        $snapshot_request->delete();

        return redirect()->route('snapshots.shows')->with('success', ['title' => 'Succès', 'message' => 'La demande de snapshot a bien été supprimée.']);
    }

    function show(Request $request, $snapshot_request_id)
    {
        $snapshot_request = SnapshotRequest::find($snapshot_request_id);
        $account = Account::find($snapshot_request->account_id);
        $priorities = ['low', 'normal', 'high', 'urgent'];

        return view('snapshots.requests.show', ['delete' => $request->query('delete', false) == '1', 'snapshot_request' => $snapshot_request, 'account' => $account, 'priorities' => $priorities]);
    }
}
