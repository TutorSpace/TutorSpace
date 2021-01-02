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
            'bonus_rate' => 0
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Intermediate I',
            'bonus_rate' => 0.05
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Intermediate II',
            'bonus_rate' => 0.06
        ]);

      
        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert I',
            'bonus_rate' => 0.07
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert II',
            'bonus_rate' => 0.08
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert III',
            'bonus_rate' => 0.09
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master I',
            'bonus_rate' => 0.12
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master II',
            'bonus_rate' => 0.15
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master III',
            'bonus_rate' => 0.20
        ]);

    }
}
