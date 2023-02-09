<?php

namespace App\Http\Controllers;

use App\Models\Wheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function shows()
    {

        $wheelsMiner = Wheel::select(
            'user_id',
            'name',
            DB::raw('COUNT(*) as total'),
            DB::raw('RANK() OVER (PARTITION BY user_id ORDER BY COUNT(*) DESC) as rank')
        )
            ->join('users', 'users.id', '=', 'wheels.user_id')
            ->groupBy('user_id')
            ->orderBy('total', 'DESC')
            ->get();


        dd($wheelsMiner);

        return view('ranking.shows');
    }
}
