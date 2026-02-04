<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        $titles = [
            'Développeur Full Stack',
            'Data Scientist',
            'Chef de Projet IT',
            'Designer UI/UX',
            'Ingénieur DevOps',
            'Consultant SAP',
            'Architecte Solutions',
            'Analyste Business Intelligence',
            'Chef de Produit Digital',
            'Ingénieur Cybersécurité',
        ];

        $specialties = [
            'Développement Web',
            'Intelligence Artificielle',
            'Gestion de Projet',
            'Design',
            'Infrastructure',
            'ERP',
            'Architecture',
            'Data',
            'Product Management',
            'Sécurité',
        ];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($titles),
            'specialty' => fake()->randomElement($specialties),
        ];
    }
}