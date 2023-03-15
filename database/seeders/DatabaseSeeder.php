<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccountUse;
use App\Models\Coupon;
use App\Models\Snapshot;
use App\Models\SnapshotRequest;
use App\Models\User;
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
        User::factory(5)->create();
        Wheel::factory(1000)->create();
        AccountUse::factory(500)->create();
        SnapshotRequest::factory(700)->create();
        Snapshot::factory(500)->create();
        Coupon::factory(200)->create();
    }
}
