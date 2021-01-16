<?php

use Illuminate\Database\Seeder;

class VerifiedCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;

        DB::table('verified_courses')->insert([
            'user_id' => $userIds[2],
            'course_id' => '6'
        ]);

        DB::table('verified_courses')->insert([
            'user_id' => $userIds[2],
            'course_id' => '4'
        ]);

        DB::table('verified_courses')->insert([
            'user_id' => $userIds[2],
            'course_id' => '5'
        ]);

        DB::table('verified_courses')->insert([
            'user_id' => $userIds[7],
            'course_id' => '5'
        ]);
    }
}
