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
use Exception;

class DropController extends Controller
{

    public function showCrowns()
    {
        $preferedReward = AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() ? AccountUse::select('reward')->groupBy('reward')->orderByRaw('COUNT(*) DESC')->first() : 'Aucune';
        $totalDrops = AccountUse::count() ? AccountUse::count() : 'Aucun';
        $totalPreferedReward = $preferedReward != 'Aucune' ? AccountUse::where('reward', $preferedReward->reward)->count() : 0;


        $accountUses = AccountUse::select('account_uses.account_id', DB::raw('MAX(account_uses.used_at) as max_date'))
            ->groupBy('account_uses.account_id')
            ->orderBy('account_uses.account_id', 'asc')
            ->get()
            ->toArray();

        $wheels = Wheel::select('wheels.account_id', DB::raw('CONVERT(SUBSTRING_INDEX(wheels.reward, "CR", -1), SIGNED) as points'), DB::raw('MAX(wheels.catched_at) as max_date'))
            ->groupBy('wheels.account_id', 'points')
            ->orderBy('wheels.account_id', 'asc')
            ->get()
            ->toArray();


        $snapshots = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'))
            ->whereNotNull('snapshots.points')
            ->groupBy('snapshots.account_id', 'snapshots.points')
            ->orderBy('snapshots.account_id', 'asc')
            ->get()
            ->toArray();

            $newAccountSnapshot = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'))
            ->whereNotNull('snapshots.points')
            ->whereNotIn('snapshots.account_id', function($query) {
                $query->select('account_uses.account_id')->from('account_uses');
            })
            ->whereNotIn('snapshots.account_id', function($query) {
                $query->select('wheels.account_id')->from('wheels');
            })
            ->groupBy('snapshots.account_id', 'snapshots.points')
            ->orderBy('snapshots.account_id', 'asc')
            ->get()
            ->toArray();

        $rewards = [];


        foreach ($wheels as $wheel) {
            $accountId = $wheel['account_id'];
            $points = $wheel['points'];
            $maxDate = $wheel['max_date'];
            $maxDateAccountUse = null;

            $addReward = true;

            foreach ($accountUses as $accountUse) {
                if ($accountUse['account_id'] === $accountId && $accountUse['max_date'] > $maxDate) {
                    $maxDateAccountUse = $accountUse['max_date'];
                    $addReward = false;
                    break;
                }
            }

            foreach ($snapshots as $snapshot) {
                if ($snapshot['account_id'] === $accountId && $snapshot['points'] === $points && $snapshot['max_date'] > $maxDate && $snapshot['max_date'] > $maxDateAccountUse) {
                    $addReward = false;
                    $found = false;
                    foreach ($rewards as &$reward) {
                        if ($reward['points'] === $snapshot['points']) {
                            $reward['total']++;
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $rewards[] = [
                            'points' => $snapshot['points'],
                            'total' => 1,
                        ];
                    }
                    break;
                }
            }

            if ($addReward) {
                $found = false;

                foreach ($rewards as &$reward) {
                    if ($reward['points'] === $points) {
                        $reward['total']++;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $rewards[] = [
                        'points' => $points,
                        'total' => 1,
                    ];
                }
            }
        }
        foreach($newAccountSnapshot as $newAccountSnap){
            $found = false;
            foreach ($rewards as &$reward) {
                if ($reward['points'] === $newAccountSnap['points']) {
                    $reward['total']++;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $rewards[] = [
                    'points' => $newAccountSnap['points'],
                    'total' => 1,
                ];
            }
        }



        // Tri des résultats par points
        usort($rewards, function ($a, $b) {
            return $b['points'] - $a['points'];
        });


        $collection = collect($rewards);

        // Transformation en objets
        $rewards = $collection->map(function ($item) {
            return (object) $item;
        });


        //dd($rewards);

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
            //->join('account_uses', 'snapshots.account_id', '=', 'account_uses.account_id')
            ->where('coupons.ending_at', '>', Carbon::now())
            ->groupBy('coupons.label')
            ->get();


        return view('drops.coupons', [
            'coupons' => $coupons,
        ]);
    }

    public function claimReward(Request $request)
    {
        try {
            $request->validate([
                'reward' => 'required|numeric',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Le gain n\'a pas été demandé ou ne respecte pas le format']);
        }

        $rewardPoints = $request->input('reward');

        $availableAccounts = [];

        $accountUses = AccountUse::select('account_uses.account_id', DB::raw('MAX(account_uses.used_at) as max_date'), DB::raw('user_id as author'))
            ->where('account_uses.reward', 'like', '%CR' . $rewardPoints)
            ->groupBy('account_uses.account_id', 'author')
            ->orderBy('account_uses.account_id', 'asc')
            ->get()
            ->toArray();

        $wheels = Wheel::select('wheels.account_id', DB::raw('CONVERT(SUBSTRING_INDEX(wheels.reward, "CR", -1), SIGNED) as points'), DB::raw('MAX(wheels.catched_at) as max_date'), DB::raw('user_id as author'))
            ->where('wheels.reward', 'like', '%CR' . $rewardPoints)
            ->groupBy('wheels.account_id', 'points', 'author')
            ->orderBy('wheels.account_id', 'asc')
            ->get()
            ->toArray();

        $snapshots = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'), DB::raw('user_id as author'))
            ->where('snapshots.points', '=', $rewardPoints)
            ->whereNotNull('snapshots.points')
            ->groupBy('snapshots.account_id', 'snapshots.points', 'author')
            ->orderBy('snapshots.account_id', 'asc')
            ->get()
            ->toArray();

        $newAccountSnapshots = Snapshot::select('snapshots.account_id', 'snapshots.points', DB::raw('MAX(snapshots.captured_at) as max_date'), DB::raw('user_id as author'))
            ->where('snapshots.points', '=', $rewardPoints)
            ->whereNotNull('snapshots.points')
            ->whereNotIn('snapshots.account_id', function ($query) {
                $query->select('account_uses.account_id')
                    ->from('account_uses');
            })
            ->whereNotIn('snapshots.account_id', function ($query) {
                $query->select('wheels.account_id')
                    ->from('wheels');
            })
            ->groupBy('snapshots.account_id', 'snapshots.points', 'author')
            ->orderBy('snapshots.account_id', 'asc')
            ->get()
            ->toArray();
       

        foreach ($wheels as $wheel) {
            $accountId = $wheel['account_id'];
            $points = $wheel['points'];
            $maxDate = $wheel['max_date'];
            $author = $wheel['author'];
            $maxDateAccountUse = null;

            $addReward = true;

            foreach ($accountUses as $accountUse) {
                if ($accountUse['account_id'] === $accountId && $accountUse['max_date'] > $maxDate) {
                    $maxDateAccountUse = $accountUse['max_date'];
                    $addReward = false;
                    break;
                }
            }

            foreach ($snapshots as $snapshot) {
                if ($snapshot['account_id'] === $accountId && $snapshot['points'] === $points && $snapshot['max_date'] > $maxDate && $snapshot['max_date'] > $maxDateAccountUse) {
                    $availableAccounts[] = [
                        'points' => $snapshot['points'],
                        'account_id' => $snapshot['account_id'],
                        'author' => $snapshot['author'],
                    ];
                    break;
                }
            }

            if ($addReward) {
                $availableAccounts[] = [
                    'points' => $points,
                    'account_id' => $accountId,
                    'author' => $author,
                ];
            }
        }
        foreach($newAccountSnapshots as $newAccountSnapshot) {
            $availableAccounts[] = [
                'points' => $newAccountSnapshot['points'],
                'account_id' => $newAccountSnapshot['account_id'],
                'author' => $newAccountSnapshot['author'],
            ];
        }


        if (count($availableAccounts) === 0) {
            return redirect()->route('drops.index')->with('error', ['title' => 'Erreur', 'message' => 'Aucun compte ne possède ce gain']);
        }

        $compte = Account::find($availableAccounts[0]['account_id']);
        $dropper = User::find($availableAccounts[0]['author']);

        if ($dropper == null) {
            $dropper = 'Maitre Splinter';
        }
        

        AccountUse::create([
            'account_id' => $compte->id,
            'user_id' => Auth::user()->id,
            'reward' => 'CR' . $rewardPoints,
            'used_at' => Carbon::now(),
        ]);

        return redirect()->route('drops.index', [
            'qrcode' => $compte->qr_code,
            'reward' => $rewardPoints,
            'dropper' => $dropper->name,
        ])->with('success', ['title' => 'Succès', 'message' => 'Le gain a bien été récupéré']);
    }

    public function claimCoupon(Request $request){

        try{
            $this->validate($request, [
                'coupon' => 'required|exists:coupons,label',
            ]) ;  
        } catch (Exception $e) {
            return redirect()->route('drops.coupons')->with('error', ['title' => 'Erreur', 'message' => 'Le coupon n\'existe pas']);
        }

        $coupon = Coupon::where('label', $request->input('coupon'))
        ->where('ending_at', '>', Carbon::now())
        ->first();

        if($coupon->ending_at < Carbon::now()){
            return redirect()->route('drops.coupons')->with('error', ['title' => 'Erreur', 'message' => 'Le coupon est expiré']);
        }

        $accountId = Snapshot::where('snapshots.id', $coupon->snapshot_id)->pluck('account_id')->first();

        if($accountId == null){
            return redirect()->route('drops.coupons')->with('error', ['title' => 'Erreur', 'message' => 'Le coupon n\'est pas encore disponible']);
        }

        $compte = Account::find($accountId);

        AccountUse::create([
            'account_id' => $compte->id,
            'user_id' => Auth::user()->id,
            'reward' => $coupon->label,
            'used_at' => Carbon::now(),
        ]);

        return redirect()->route('drops.coupons', [
            'qrcode' => $compte->qr_code,
            'reward' => $coupon->label,
        ])->with('success', ['title' => 'Succès', 'message' => 'Le coupon a bien été récupéré']);


    }

    public function showMyDrops()
    {

        $myDrops = AccountUse::select(DB::raw("IF(account_uses.reward LIKE 'CR%', CONVERT(SUBSTRING_INDEX(account_uses.reward, 'CR', -1), SIGNED), account_uses.reward) as points"), DB::raw('MAX(account_uses.used_at) as date'), 'accounts.qr_code')
            ->join('accounts', 'account_uses.account_id', '=', 'accounts.id')
            ->where('account_uses.used_at', '>', Carbon::now()->subDays(1))
            ->where('account_uses.user_id', '=', Auth::user()->id)
            ->groupBy('points', 'qr_code', 'account_uses.used_at')
            ->orderBy('account_uses.used_at', 'desc')
            ->get();

        $totalDrops = AccountUse::select(DB::raw('COUNT(*) as total'))
            ->where('account_uses.user_id', '=', Auth::user()->id)
            ->get();


        return view('drops.mydrops', [
            'myDrops' => $myDrops,
            'totalDrops' => $totalDrops->first()->total,
        ]);
    }
}
