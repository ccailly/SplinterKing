<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountUse;
use App\Models\Wheel;
use App\Models\Snapshot;
use App\Models\Account;

class DropController extends Controller
{
    public function index()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first();
        $total = AccountUse::count();
        $totalPreferedReward = $preferedReward ? AccountUse::where('reward', $preferedReward->reward)->count() : 'Aucun';

        $snapshots = Snapshot::select('account_id')->join("account_uses","snapshots.captured_at", "=", "account_uses.used_at")->where("snapshots.captured_at", ">", "account_uses.used_at");

        return view('drop', [
            'preferedReward' => $preferedReward ? $preferedReward->reward : "CR120",
            'total' => $total,
            'totalPreferedReward' => $totalPreferedReward,
            'snapshots' => $snapshots
        ]);
    }

}
