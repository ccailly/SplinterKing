<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wheel>
 */
class WheelFactory extends Factory
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
            'reward' => $this->faker->randomElement(['CR30', 'CR80', 'CR120', 'CR140', 'CR180', 'CR220']),
            'user_id' => 1,
        ];
    }
}
