<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;

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
        return [
            'account_id' => $this->faker->numberBetween(Account::min('id'), Account::max('id')),
            'user_id' => 1,
            'reward' => $this->faker->randomElement(['CR30', 'CR80', 'CR120', 'CR140', 'CR180', 'CR220']),
            'used_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
