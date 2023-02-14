<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountUse;
use App\Models\Account;
use App\Models\User;
use App\Models\Wheel;
use App\Models\Snapshot;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DropController extends Controller
{
    public function showCrowns()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() ? AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() : 'Aucune';
        $totalDrops = AccountUse::count() ? AccountUse::count() : 'Aucun';
        $totalPreferedReward = $preferedReward != 'Aucune' ? AccountUse::where('reward', $preferedReward->reward)->count() : 0;

        // $rewards = Snapshot::select('points', DB::raw('count(*) as total'))
        //     ->fromSub(function ($query) {
        //         $query->select('snapshots.*')
        //             ->selectRaw('(SELECT MAX(used_at) FROM account_uses WHERE snapshots.account_id = account_uses.account_id) AS latest_used_at')
        //             ->from('snapshots')
        //             ->leftJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id');
        //     }, 'subquery')
        //     ->whereRaw('subquery.captured_at > subquery.latest_used_at')
        //     ->groupBy('points')
        //     ->orderBy('points', 'desc')
        //     ->get();

        $wheels = Wheel::select('wheels.account_id', DB::raw('CONVERT(SUBSTRING_INDEX(wheels.reward, "CR", -1), SIGNED) as points'), DB::raw('MAX(wheels.catched_at) as max_date'))
            ->rightJoin('account_uses', 'wheels.account_id', '=', 'account_uses.account_id', 'and', 'wheels.catched_at', '>', 'account_uses.used_at', 'and', 'wheels.reward', '=', 'account_uses.reward')
            ->groupBy('wheels.account_id', 'points')
            ->orderBy('wheels.account_id', 'asc')
            ->get();

        $snapshots = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'))
            ->rightJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id', 'and', 'snapshots.captured_at', '>', 'account_uses.used_at', 'and', 'snapshots.points', '=', 'SUBSTRING_INDEX(account_uses.reward, "CR", -1)')
            ->whereNotNull('snapshots.points')
            ->groupBy('snapshots.account_id', 'snapshots.points')
            ->orderBy('snapshots.account_id', 'asc')
            ->get();

        $merged = $wheels->concat($snapshots)->groupBy('account_id');

        $rewards = collect();
        foreach ($merged as $group) {
            $reward = $group->sortByDesc('max_date')->first();
            $rewards->push(
                (object) [
                    'points' => $reward['points'],
                    'total' => $group->count(),
                ]
            );
        }

        $rewards = $rewards->groupBy('points')->map(function ($group) {
            return (object) [
                'points' => $group->first()->points,
                'total' => $group->sum('total'),
            ];
        });

        $rewards = $rewards->sortByDesc('points');

        return view('drops.drop', [
            'preferedReward' => $preferedReward != 'Aucune' ? intval(str_replace('CR', '', $preferedReward->reward)) : $preferedReward,
            'total' => $totalDrops,
            'totalPreferedReward' => $totalPreferedReward,
            'rewards' => $rewards,
        ]);
    }

    public function showCoupons()
    {

        $coupons = Coupon::select('coupons.label', DB::raw('count(*) as total'), DB::raw('DATEDIFF(MAX(coupons.ending_at), NOW()) as remaining_days'))
            ->join('snapshots', 'coupons.snapshot_id', '=', 'snapshots.id')
            ->where('coupons.ending_at', '>', Carbon::now())
            ->groupBy('coupons.label')
            ->get();


        return view('drops.coupons', [
            'coupons' => $coupons,
        ]);
    }

    public function getReward(Request $request)
    {
        try {
            $request->validate([
                'reward' => 'required|numeric',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Le gain n\'a pas été demandé ou ne respecte pas le format']);
        }


        //verifier si le reward est bien un reward existant
        $reward = Snapshot::select('points')->where('points', $request->reward)->first();
        if ($reward) {
            $reward = $reward->points;

            $wheels = Wheel::select('wheels.account_id', DB::raw('CONVERT(SUBSTRING_INDEX(wheels.reward, "CR", -1), SIGNED) as points'), DB::raw('MAX(wheels.catched_at) as max_date'), 'wheels.user_id')
                ->rightJoin('account_uses', 'wheels.account_id', '=', 'account_uses.account_id', 'and', 'wheels.catched_at', '>', 'account_uses.used_at', 'and', 'wheels.reward', '=', 'account_uses.reward')
                ->where('wheels.reward', 'CR' . $reward)
                ->groupBy('wheels.account_id', 'points', 'wheels.user_id')
                ->orderBy('wheels.account_id', 'asc')
                ->get();

            $snapshots = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'), 'snapshots.user_id')
                ->rightJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id', 'and', 'snapshots.captured_at', '>', 'account_uses.used_at', 'and', 'snapshots.points', '=', 'SUBSTRING_INDEX(account_uses.reward, "CR", -1)')
                ->whereNotNull('snapshots.points')
                ->where('snapshots.points', $reward)
                ->groupBy('snapshots.account_id', 'snapshots.points', 'snapshots.user_id')
                ->orderBy('snapshots.account_id', 'asc')
                ->get();

            //recuperer le qrcode et l'id du compte avec le reward correspondant. Utiliser la meme logique que la methode showCrowns

            $merged = $wheels->concat($snapshots)->groupBy('account_id');

            $rewards = collect();
            foreach ($merged as $group) {
                $reward = $group->sortByDesc('max_date')->first();
                $rewards->push(
                    (object) [
                        'points' => $reward['points'],
                        'account_id' => $reward['account_id'],
                        'user_id' => $reward['user_id'],
                    ]
                );
            }

            $compte = Account::select('accounts.qr_code', 'accounts.id')
                ->where('accounts.id', $rewards->first()->account_id)
                ->first();

            $user = User::select('users.name')
                ->where('users.id', $rewards->first()->user_id)
                ->first();


            if (!$compte) {
                return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Ce gain n\'est plus disponible']);
            }

            $add = AccountUse::create([
                'account_id' => $compte->id,
                'user_id' => Auth::user()->id,
                'reward' => "CR" . $reward,
                'used_at' => now(),
            ]);

            if (!$add) {
                return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Ce gain n\'est plus disponible']);
            }
        } else {
            return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Ce gain n\'est plus disponible']);
        }

        return redirect()->route('drops.index', [
            'qrcode' => $compte->qr_code,
            'reward' => $reward,
            'dropper' => $user->name
        ])->with('success', ['title' => 'Succès', 'message' => 'Le gain a bien été récupéré']);
    }
}
