<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\JobOffer;
use App\Models\Application;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $skills = Skill::factory(20)->create();

        $recruiters = User::factory(10)
            ->recruiter()
            ->create()
            ->each(function ($recruiter) {
                JobOffer::factory(rand(2, 5))->create([
                    'user_id' => $recruiter->id,
                ]);
            });

        $jobSeekers = User::factory(30)
            ->jobSeeker()
            ->create()
            ->each(function ($user) use ($skills) {
                $profile = Profile::factory()->create([
                    'user_id' => $user->id,
                ]);

                Education::factory(rand(2, 3))->create([
                    'profile_id' => $profile->id,
                ]);

                Experience::factory(rand(1, 4))->create([
                    'profile_id' => $profile->id,
                ]);

                $randomSkills = $skills->random(rand(3, 8));
                $profile->skills()->attach($randomSkills);
            });

        $jobOffers = JobOffer::all();
        foreach ($jobSeekers->random(20) as $jobSeeker) {
            $randomOffers = $jobOffers->random(rand(1, 5));
            foreach ($randomOffers as $offer) {
                Application::create([
                    'user_id' => $jobSeeker->id,
                    'job_offer_id' => $offer->id,
                    'status' => fake()->randomElement(['pending', 'reviewed', 'accepted', 'rejected']),
                ]);
            }
        }

        foreach ($jobSeekers->random(15) as $jobSeeker) {
            $friends = $jobSeekers->except($jobSeeker->id)->random(rand(2, 5));
            foreach ($friends as $friend) {
                if (!$jobSeeker->hasPendingFriendRequestWith($friend) && !$jobSeeker->isFriendWith($friend)) {
                    \App\Models\Friendship::create([
                        'user_id' => $jobSeeker->id,
                        'friend_id' => $friend->id,
                        'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
                    ]);
                }
            }
        }

        $testRecruiter = User::factory()->recruiter()->create([
            'name' => 'Recruteur Test',
            'email' => 'recruiter@test.com',
            'password' => bcrypt('password'),
        ]);

        JobOffer::factory(3)->create([
            'user_id' => $testRecruiter->id,
        ]);

        $testJobSeeker = User::factory()->jobSeeker()->create([
            'name' => 'Candidat Test',
            'email' => 'candidate@test.com',
            'password' => bcrypt('password'),
        ]);

        $testProfile = Profile::factory()->create([
            'user_id' => $testJobSeeker->id,
        ]);

        Education::factory(2)->create(['profile_id' => $testProfile->id]);
        Experience::factory(2)->create(['profile_id' => $testProfile->id]);
        $testProfile->skills()->attach($skills->random(5));

        $this->command->info('Base de données peuplée avec succès!');
        $this->command->info('Recruteur test: recruiter@test.com / password');
        $this->command->info('Candidat test: candidate@test.com / password');
    }
}