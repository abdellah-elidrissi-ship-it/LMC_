<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultant>
 */
class ConsultantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom_complet' => fake()->name(),
            'type_consultant' => fake()->randomElement(['Interne', 'Freelancer']),
            'specialite' => fake()->randomElement(['ISO 9001', 'ISO 14001', 'ISO 45001']),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->phoneNumber(),
            'actif' => true,
        ];
    }
}
