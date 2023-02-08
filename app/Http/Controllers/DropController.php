<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountUse;
use App\Models\Wheel;
use App\Models\Snapshot;
use Illuminate\Support\Facades\DB;

class DropController extends Controller
{
    public function index()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first();
        $total = AccountUse::count();
        $totalPreferedReward = $preferedReward ? AccountUse::where('reward', $preferedReward->reward)->count() : 'Aucun';

        $rewards = Snapshot::select('points', DB::raw('COUNT(*) as total'))
            ->join('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id')
            //->where('snapshots.captured_at', '>', 'account_uses.used_at')
            ->groupBy('points')
            ->orderBy('points', 'desc')
            ->get();

        return view('drops.drop', [
            'preferedReward' => $preferedReward ? $preferedReward->reward : "CR120",
            'total' => $total,
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
            $qrcode = Snapshot::select('accounts.qr_code')
                ->join('accounts', 'snapshots.account_id', '=', 'accounts.id')
                ->where('snapshots.points', $reward)
                ->first();
        } else {
            return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Ce gain n\'est plus disponible']);
        }

        return redirect()->route('drops.index', [
            'qrcode' => $qrcode->qr_code,
            'reward' => $reward,
        ])->with('success', ['title' => 'Succès', 'message' => 'Le gain a bien été récupéré']);
    }
}
