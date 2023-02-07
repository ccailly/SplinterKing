<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountUse;

class DropController extends Controller
{
    public function index()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first()->reward;
        $total = AccountUse::count();
        $totalPreferedReward = AccountUse::where('reward', $preferedReward)->count();
        return view('drop', [
            'preferedReward' => $preferedReward,
            'total' => $total,
            'totalPreferedReward' => $totalPreferedReward
        ]);
    }

}
