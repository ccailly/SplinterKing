<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\SnapshotRequest;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckAccountsSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snapshot:checkaccounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all accounts and check if their lastest snapshot is older than 1 month. If so, create a snapshot request';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $accounts = Account::leftJoin('snapshots', 'accounts.id', '=', 'snapshots.account_id')
            ->where('snapshots.captured_at', '<', Carbon::now()->subMonth())
            ->orWhere('snapshots.captured_at', null)
            ->whereNotIn('accounts.id', function ($query) {
                $query->select('account_id')->from('snapshot_requests')->whereIn('status', ['pending', 'processing']);
            })
            ->select('accounts.id')
            ->get();
        if ($accounts->count() == 0) {
            $this->info('⭕ No account to check');
            return Command::SUCCESS;
        }

        $this->info('✅ ' . $accounts->count() . ' accounts to check');
        $this->info('✅ Creating snapshot requests');

        $snapshotRequests = [];
        foreach ($accounts as $account) {
            $snapshotRequests[] = [
                'account_id' => $account->id,
            ];
        }
        SnapshotRequest::insert($snapshotRequests);        
        
        $this->info('✅ Snapshot requests created');

        return Command::SUCCESS;
    }
}
