<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Coupon;
use App\Models\Lock;
use App\Models\Snapshot;
use App\Models\SnapshotRequest;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Exception;

class RunSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snapshot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes a snapshot of the pending snapshot that has higher priority';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the pending snapshot request with higher priority
        $snapshotRequest = SnapshotRequest::where('status', 'pending')->whereNotIn('account_id', Lock::select('account_id')->get()->pluck('account_id')->toArray())
            ->orderByDesc('priority')->first();

        if (!$snapshotRequest) {
            $this->info('⭕ No pending snapshot request found');
            return Command::SUCCESS;
        }

        $this->info('✅ Snapshot request found');

        // Switch the status to processing
        $snapshotRequest->status = 'processing';
        $snapshotRequest->save();
        $this->info('✅ Snapshot request status switched to processing');

        // Lock the account
        $lock = new Lock();
        $lock->account_id = $snapshotRequest->account_id;
        if ($snapshotRequest->user_id)
            $lock->user_id = $snapshotRequest->user_id;
        $lock->save();
        $this->info('✅ Account locked');

        // Get the account
        $account = Account::find($snapshotRequest->account_id);

        // Execute the python script and get the json result
        try {
            $resultRaw = ShellCommand::execute('python3.10 ./scripts/snapshot/snapshot.py ' . $account->mail . ' ' . $account->password);
            if (isset($resultRaw['error']))
                throw new Exception($resultRaw['error']);
        } catch (Exception $e) {
            $this->error('⛔ ' . $e->getMessage());

            // Switch the status to failed
            $snapshotRequest->status = 'failed';
            $snapshotRequest->save();
            $this->info('☑️ Snapshot request status switched to failed');

            // Unlock the account
            $lock->delete();
            $this->info('☑️ Account unlocked');

            return Command::FAILURE;
        }

        $this->info($resultRaw);
        $result = json_decode($resultRaw, true);
        $this->info('✅ Snapshot information retrieved');

        // Create the snapshot
        $snapshot = new Snapshot();
        $snapshot->snapshot_request_id = $snapshotRequest->id;
        $snapshot->account_id = $account->id;
        if ($snapshotRequest->user_id)
            $snapshot->user_id = $snapshotRequest->user_id;
        $snapshot->points = $result['points'];
        $snapshot->save();
        $this->info('✅ Snapshot created');

        // Create the coupons
        foreach ($result['coupons'] as $couponData) {
            $coupon = new Coupon();
            $coupon->id = $couponData['id'];
            $coupon->snapshot_id = $snapshot->id;
            $coupon->label = $couponData['label'];
            $coupon->description = $couponData['description'];
            $coupon->ending_at = Carbon::createFromFormat('d/m/Y', $couponData['ending_at'])->format('Y-m-d');
            $coupon->save();
            $this->info('✅ Coupon created');
        }

        // Update account birthdate and kids status
        $account->birth_date = Carbon::createFromFormat('d/m/Y', $result['birthdate'])->format('Y-m-d');
        $account->has_kids = $result['hasKids'];
        $account->save();
        $this->info('✅ Account updated');

        // Unlock the account
        $lock->delete();
        $this->info('✅ Account unlocked');

        // Switch the status to completed
        $snapshotRequest->status = 'completed';
        $snapshotRequest->save();
        $this->info('✅ Snapshot request status switched to completed');

        return Command::SUCCESS;
    }
}
