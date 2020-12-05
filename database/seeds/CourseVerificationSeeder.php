<?php

use Illuminate\Database\Seeder;

class CourseVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_verifications')->insert([
            'user_id' => '2',
            'course_id' => '6'
        ]);

        DB::table('course_verifications')->insert([
            'user_id' => '2',
            'course_id' => '4'
        ]);

        DB::table('course_verifications')->insert([
            'user_id' => '2',
            'course_id' => '5'
        ]);

        DB::table('course_verifications')->insert([
            'user_id' => '7',
            'course_id' => '5'
        ]);

    }
}
