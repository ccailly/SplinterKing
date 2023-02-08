<?php

namespace Database\Factories;

use App\Models\SnapshotRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SnapshotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'snapshot_request_id' => $this->faker->numberBetween(SnapshotRequest::min('id'), SnapshotRequest::max('id')),
            'account_id' => $this->faker->numberBetween(1, 2000),
            'user_id' => 1,
            'points' => $this->faker->randomElement([30, 80, 120, 140, 180, 220]),
            'captured_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
