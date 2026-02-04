<?php

namespace Database\Factories;

use App\Models\Education;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition(): array
    {
        $degrees = [
            'Licence en Informatique',
            'Master en Data Science',
            'Ingénieur en Génie Logiciel',
            'MBA',
            'Doctorat en Intelligence Artificielle',
            'DUT Informatique',
            'BTS SIO',
            'Master en Gestion de Projet',
            'Licence en Commerce',
            'Master en Marketing Digital',
        ];

        $schools = [
            'ENSIAS',
            'INPT',
            'EMSI',
            'Université Mohammed V',
            'FST Mohammedia',
            'ENSA',
            'HEC Montréal',
            'INSEA',
            'Polytechnique Paris',
            'Université Paris-Saclay',
        ];

        return [
            'profile_id' => Profile::factory(),
            'degree' => fake()->randomElement($degrees),
            'school' => fake()->randomElement($schools),
            'year_obtained' => fake()->year(),
        ];
    }
}