<?php

namespace Database\Factories;

use App\Models\Consultant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tache>
 */
class TacheFactory extends Factory
{
    public function definition(): array
    {
        return [
            'consultant_id' => Consultant::factory(),
            'client_id' => null,
            'assigned_by' => null,
            'titre' => fake()->sentence(4),
            'objectif' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'heure_debut' => '09:00',
            'heure_fin' => '11:00',
            'statut' => 'Assignée',
        ];
    }
}
