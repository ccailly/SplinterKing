<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountUse;
use App\Models\Snapshot;
use App\Models\SnapshotRequest;
use App\Models\Wheel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        AccountUse::factory(500)->create();
        SnapshotRequest::factory(500)->create();
        Snapshot::factory(500)->create();
        Wheel::factory(500)->create();
    }
}
