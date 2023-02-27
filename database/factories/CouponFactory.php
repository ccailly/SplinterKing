<?php

namespace Database\Factories;

use App\Models\Snapshot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            "id" => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            "snapshot_id" => $this->faker->numberBetween(Snapshot::min('id'), Snapshot::max('id')),
            "label" => $this->faker->randomElement(['1 Whopper offert pour votre anniversaire', 'Wrap a 3€', 'Steakhouse a 3€', 'King Bio Fruit']),
            "description" => "Offre valable un mois hors service de livraison. Retrouvez la liste des restaurants participants et les conditions générales d’utilisation du programme de fidélité Kingdom sur l'application Burger King France et sur burgerking.fr. Pour connaitre le détail des produits offerts dans le cadre du Programme de fidélité Kingdom, consultez les conditions générales d’utilisation disponibles sur l'application Burger King France et sur burgerking.fr.",
            "ending_at" => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
