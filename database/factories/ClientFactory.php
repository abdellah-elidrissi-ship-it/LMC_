<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom_client' => fake()->company(),
            'secteur_activite' => fake()->randomElement(['Industrie', 'Agroalimentaire', 'BTP', 'Services']),
            'adresse' => fake()->address(),
            'telephone' => fake()->phoneNumber(),
            'email_contact' => fake()->unique()->companyEmail(),
        ];
    }
}
