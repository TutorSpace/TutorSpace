<?php

use Illuminate\Database\Seeder;

class TutorLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Beginner',
            'bonus_rate' => 0,
            'level_experience_lower_bound' => -1000000,
            'level_experience_upper_bound' => 30,
            'hourly_rate_upper_bound' => 15,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Intermediate I',
            'bonus_rate' => 0.05,
            'level_experience_lower_bound' => 30,
            'level_experience_upper_bound' => 130,
            'hourly_rate_upper_bound' => 17,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Intermediate II',
            'bonus_rate' => 0.06,
            'level_experience_lower_bound' => 130,
            'level_experience_upper_bound' => 430,
            'hourly_rate_upper_bound' => 19,
        ]);


        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert I',
            'bonus_rate' => 0.07,
            'level_experience_lower_bound' => 430,
            'level_experience_upper_bound' => 1030,
            'hourly_rate_upper_bound' => 30,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert II',
            'bonus_rate' => 0.08,
            'level_experience_lower_bound' => 1030,
            'level_experience_upper_bound' => 2030,
            'hourly_rate_upper_bound' => 42,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert III',
            'bonus_rate' => 0.09,
            'level_experience_lower_bound' => 2030,
            'level_experience_upper_bound' => 3630,
            'hourly_rate_upper_bound' => 60,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master I',
            'bonus_rate' => 0.12,
            'level_experience_lower_bound' => 3630,
            'level_experience_upper_bound' => 6130,
            'hourly_rate_upper_bound' => 1000,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master II',
            'bonus_rate' => 0.15,
            'level_experience_lower_bound' => 6130,
            'level_experience_upper_bound' => 11130,
            'hourly_rate_upper_bound' => 1000,
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master III',
            'bonus_rate' => 0.20,
            'level_experience_lower_bound' => 11130,
            'level_experience_upper_bound' => 10000000,
            'hourly_rate_upper_bound' => 1000,
        ]);

    }
}
