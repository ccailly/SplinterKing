<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function add(Request $request)
    {
        $request->validate([
            'mail' => 'required|unique:accounts,mail',
            'password' => 'required',
            'qr_code' => 'required',
            'birth_date' => 'required|date',
        ]);

        $account = new Account();
        $account->mail = $request->mail;
        $account->password = $request->password;
        $account->qr_code = $request->qr_code;
        $account->user_id = Auth::id();
        $account->birth_date = $request->birth_date;
        $account->save();

        return response()->json([
            'message' => 'Account added successfully',
            'account' => $account
        ], 201);
    }
}
