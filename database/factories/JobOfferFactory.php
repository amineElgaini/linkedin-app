<?php

namespace Database\Factories;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    protected $model = JobOffer::class;

    public function definition(): array
    {
        $titles = [
            'Développeur Laravel Senior',
            'Chef de Projet Digital',
            'Data Scientist',
            'Designer UI/UX',
            'Ingénieur DevOps',
            'Consultant Fonctionnel',
            'Développeur Mobile React Native',
            'Architecte Cloud',
            'Analyste de Données',
            'Chef de Produit',
        ];

        return [
            'user_id' => User::factory()->recruiter(),
            'company_name' => fake()->company(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->paragraphs(3, true),
            'contract_type' => fake()->randomElement(['CDI', 'CDD', 'Full-time', 'Stage', 'Freelance']),
            'image' => fake()->imageUrl(800, 400, 'business'),
            'status' => fake()->randomElement(['open', 'open', 'open', 'closed']), // 75% open
        ];
    }

    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'closed',
        ]);
    }
}