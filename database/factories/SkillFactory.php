<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        $skills = [
            'Laravel',
            'PHP',
            'JavaScript',
            'React',
            'Vue.js',
            'Python',
            'Java',
            'SQL',
            'MongoDB',
            'Docker',
            'Kubernetes',
            'AWS',
            'Git',
            'Agile/Scrum',
            'Leadership',
            'Communication',
            'Gestion de Projet',
            'Analyse de Données',
            'Machine Learning',
            'Cybersécurité',
        ];

        return [
            'name' => fake()->unique()->randomElement($skills),
        ];
    }
}