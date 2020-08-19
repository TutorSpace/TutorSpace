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
            'tutor_level' => 'Beginner'
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Intermediate'
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Expert'
        ]);

        DB::table('tutor_levels')->insert([
            'tutor_level' => 'Master'
        ]);

    }
}
