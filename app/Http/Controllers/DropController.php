<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountUse;
use App\Models\Wheel;
use App\Models\Snapshot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DropController extends Controller
{
    public function showCrowns()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() ? AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() : 'Aucune';
        $totalDrops = AccountUse::count() ? AccountUse::count() : 'Aucun';
        $totalPreferedReward = $preferedReward ? AccountUse::where('reward', $preferedReward->reward)->count() : 'Aucun';

        $rewards = Snapshot::select('points', DB::raw('count(*) as total'))
            ->fromSub(function ($query) {
                $query->select('snapshots.*')
                      ->selectRaw('(SELECT MAX(used_at) FROM account_uses WHERE snapshots.account_id = account_uses.account_id) AS latest_used_at')
                      ->from('snapshots')
                      ->leftJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id');
            }, 'subquery')
            ->whereRaw('subquery.captured_at > subquery.latest_used_at')
            ->groupBy('points')
            ->orderBy('points', 'desc')
            ->get();

        return view('drops.drop', [
            'preferedReward' => $preferedReward ? intval(str_replace('CR', '', $preferedReward->reward)) : "120",
            'total' => $totalDrops,
            'totalPreferedReward' => $totalPreferedReward,
            'rewards' => $rewards,
        ]);
    }

    public function showCoupons()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() ? AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() : 'Aucune';
        $totalDrops = AccountUse::count() ? AccountUse::count() : 'Aucun';
        $totalPreferedReward = $preferedReward ? AccountUse::where('reward', $preferedReward->reward)->count() : 'Aucun';

        $rewards = Snapshot::select('points', DB::raw('count(*) as total'))
            ->fromSub(function ($query) {
                $query->select('snapshots.*')
                      ->selectRaw('(SELECT MAX(used_at) FROM account_uses WHERE snapshots.account_id = account_uses.account_id) AS latest_used_at')
                      ->from('snapshots')
                      ->leftJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id');
            }, 'subquery')
            ->whereRaw('subquery.captured_at > subquery.latest_used_at')
            ->groupBy('points')
            ->orderBy('points', 'desc')
            ->get();

        return view('drops.drop', [
            'preferedReward' => $preferedReward ? intval(str_replace('CR', '', $preferedReward->reward)) : "120",
            'total' => $totalDrops,
            'totalPreferedReward' => $totalPreferedReward,
            'rewards' => $rewards,
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

            //recuperer le qrcode du compte avec le reward correspondant
            $compte = Snapshot::select('accounts.qr_code', 'accounts.id')
                ->join('accounts', 'snapshots.account_id', '=', 'accounts.id')
                ->where('snapshots.points', $reward)
                ->whereIn('snapshots.account_id',
                Snapshot::select('snapshots.account_id')
                    ->leftJoin('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id')
                    ->whereRaw('snapshots.captured_at > account_uses.used_at')
                    ->groupBy('account_id')
                    ->orderBy('account_id', 'desc')
                    ->get()
                    ->pluck('account_id')
                )
                ->first();

                if (!$compte){
                    return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Ce gain n\'est plus disponible']);
                }
             
                $add = AccountUse::create([
                    'account_id' => $compte->id,
                    'user_id' => Auth::user()->id,
                    'reward' => "CR".$reward,
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
        ])->with('success', ['title' => 'Succès', 'message' => 'Le gain a bien été récupéré']);
    }
}
