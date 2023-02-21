<?php

namespace App\Console\Commands;

use App\Models\Lock;
use Illuminate\Console\Command;

class ClearLock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lock:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all locks older than 1 hour.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $locks = Lock::where('locked_at', '<', now()->subHour())->get();
        $this->info('✅ ' . $locks->count() . ' locks found');
        foreach ($locks as $lock) {
            $lock->delete();
        }
        $this->info('✅ All locks deleted');

        return Command::SUCCESS;
    }
}
