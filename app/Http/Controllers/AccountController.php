<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function shows(Request $request)
    {
        $page = $request->query('page', 1);
        $sort = $request->query('sort', 'created_at');
        $search = $request->query('search', '');
        $account_per_page = 30.0;
        $accounts = Account::leftJoin('snapshots', 'snapshots.mail', '=', 'accounts.mail')
            ->leftJoin('coupons', 'coupons.snapshot_id', '=', 'snapshots.id')
            ->where('coupons.ending_at', '>', DB::raw('NOW()'))->orWhereNull('coupons.ending_at')
            ->where('accounts.mail', 'like', '%' . $search . '%')
            ->orWhere('accounts.qr_code', 'like', '%' . $search . '%')
            ->orWhere('accounts.password', 'like', '%' . $search . '%')
            ->orWhere('snapshots.points', 'like', '%' . $search . '%')
            ->select('accounts.mail', 'password', 'qr_code', DB::raw('IFNULL(points, \'...\') as points'), DB::raw('count(coupons.id) as coupons'))
            ->groupBy('accounts.mail', 'password', 'qr_code', 'points')
            ->orderByDesc($sort);
        $total = $accounts->get()->count();
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
            'buttons' => [
                "secondary" => [
                    "name" => "Tâches de création de compte",
                    "url" => route('accounts.add'),
                    "icon" => "user-circle",
                ],
                "primary" => [
                    "name" => "Ajouter un compte",
                    "url" => route('accounts.add'),
                    "icon" => "plus-circle",
                ],
            ],
            'search' => [
                'url' => route('accounts.shows'),
                'placeholder' => 'Rechercher un compte',
                'value' => $search,
            ],
            'columns' => ['mail', 'password', 'qr_code', 'Couronnes', 'coupons'],
            'rows' => $accounts->skip(($page - 1) * $account_per_page)->take($account_per_page)->get()->toArray(),
            'actions' => ['Afficher' => [
                'url' => 'accounts.shows',
            ], 'QR Code' => [
                'url' => 'accounts.shows',
            ], 'Supprimer' => [
                'url' => 'accounts.shows',
            ]],
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
}
