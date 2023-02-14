<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\User;
use App\Models\Wheel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AccountUseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $account_id = Wheel::select('wheels.account_id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('account_id')
            ->first();

        return [
            'account_id' => $account_id,
            'user_id' => $this->faker->numberBetween(User::min('id'), User::max('id')),
            'reward' => Wheel::select('reward')->where('account_id', $account_id)->first()->reward,
            'used_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
