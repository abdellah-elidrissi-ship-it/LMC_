<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Consultant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projet>
 */
class ProjetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reference_projet' => 'PRJ-' . fake()->unique()->numerify('####'),
            'client_id' => Client::factory(),
            'chef_projet_id' => Consultant::factory(),
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'En cours',
            'jours_prevus' => 20,
            'jours_realises' => 0,
            'avancement_percent' => 0,
        ];
    }
}
