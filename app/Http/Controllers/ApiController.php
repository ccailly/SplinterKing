<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Lock;
use App\Models\Wheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function addAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail' => 'required|unique:accounts,mail',
            'password' => 'required',
            'qr_code' => 'required',
            'birth_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

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

    public function getWheelAccount()
    {
        $account = Account::whereNotIn('id', Lock::select('account_id'))->first();

        if ($account) {
            $lock = new Lock();
            $lock->account_id = $account->id;
            $lock->user_id = Auth::id();
            $lock->save();
        } else {
            return response()->json([
                'message' => 'No account available',
            ], 404);
        }

        return response()->json([
            'message' => 'Account fetched and locked successfully',
            'account' => $account
        ], 200);
    }

    public function addWheelAccountReward(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|exists:accounts,id|exists:locks,account_id',
            'reward' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $account = Account::find($request->account_id);
        $wheel = new Wheel();
        $wheel->account_id = $account->id;
        $wheel->reward = $request->reward;
        $wheel->user_id = Auth::id();
        $wheel->save();

        $lock = Lock::where('account_id', $request->account_id)->first();
        $lock->delete();

        return response()->json([
            'message' => 'Account reward added successfully',
            'account' => $account,
            'wheel' => $wheel
        ], 200);
    }
}
