<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function shows()
    {
        $datas = $this->wheelsRanking();
        return view('ranking.shows', compact('datas'));
    }

    public function showsWheelsRanking()
    {
        $datas = $this->wheelsRanking();
        return view('ranking.shows', compact('datas'));
    }

    public function showsEatersRanking()
    {
        $datas = $this->eatersRanking();
        return view('ranking.shows', compact('datas'));
    }

    public function wheelsRanking()
    {
        $wheelsMiners = DB::select(DB::raw("SET @rank := 0;"));
        $wheelsMiners = User::select(
            'users.id as id',
            'users.name as name',
            DB::raw('count(wheels.id) as total'),
            DB::raw('@rank := @rank + 1 as user_rank')
        )
            ->selectRaw('(CASE WHEN (SELECT MAX(wheels.catched_at) FROM wheels WHERE wheels.user_id = users.id) > (NOW() - INTERVAL 5 MINUTE) THEN "Running" ELSE "Stopped" END) as info')
            ->leftJoin('wheels', 'users.id', '=', 'wheels.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('user_rank', 'asc')
            ->get();

        return $wheelsMiners;
    }

    public function eatersRanking()
    {
        $eaters = DB::select(DB::raw("SET @rank := 0;"));
        $eaters = User::select(
            'users.id as id',
            'users.name as name',
            DB::raw('count(account_id) as total'),
            DB::raw('@rank := @rank + 1 as user_rank'),
            DB::raw('IFNULL(reward_subquery.reward, "Aucun") as info')
        )
            ->leftJoin('account_uses', 'users.id', '=', 'account_uses.user_id')
            ->leftJoin(DB::raw('(SELECT id, (
                SELECT reward from account_uses au WHERE u.id = au.user_id  GROUP BY user_id , reward ORDER BY COUNT(reward) DESC LIMIT 1 
            ) as reward FROM users u ORDER BY id ASC) reward_subquery'), function ($join) {
                $join->on('reward_subquery.id', '=', 'users.id');
            })
            ->groupBy('users.id', 'users.name', 'reward_subquery.reward')
            ->orderBy('user_rank', 'asc')
            ->get();

        return $eaters;
    }
}
