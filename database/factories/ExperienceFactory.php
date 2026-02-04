<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        $positions = [
            'Développeur Full Stack',
            'Chef de Projet',
            'Data Analyst',
            'Designer UI/UX',
            'Product Owner',
            'DevOps Engineer',
            'Consultant IT',
            'Business Analyst',
            'Scrum Master',
            'Tech Lead',
        ];

        $companies = [
            'Capgemini',
            'Accenture',
            'Deloitte',
            'OCP',
            'BMCE Bank',
            'Maroc Telecom',
            'Attijariwafa Bank',
            'CGI',
            'Wavestone',
            'Sopra Steria',
        ];

        $durations = [
            '6 mois',
            '1 an',
            '2 ans',
            '3 ans',
            '4 ans',
            '5 ans',
        ];

        return [
            'profile_id' => Profile::factory(),
            'position' => fake()->randomElement($positions),
            'company' => fake()->randomElement($companies),
            'duration' => fake()->randomElement($durations),
        ];
    }
}