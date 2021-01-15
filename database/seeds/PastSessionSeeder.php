<?php

use App\Session;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PastSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;
        $pastSessionIds = DatabaseSeeder::$pastSessionIds;

        Session::create([
            'id' => $pastSessionIds[0],
            'tutor_id' => $userIds[2],
            'student_id' => $userIds[0],
            'course_id' => '1',
            'is_in_person' => true,
            'session_time_start' => Carbon::now()->addHours(-2),
            'session_time_end' => Carbon::now()->addHours(-1),
            'is_upcoming' => false,
            'hourly_rate' => 14,
        ]);

        Session::create([
            'id' => $pastSessionIds[1],
            'tutor_id' => $userIds[2],
            'student_id' => $userIds[1],
            'course_id' => '5',
            'is_in_person' => false,
            'session_time_start' => Carbon::now()->addHours(-3)->addMinutes(30),
            'session_time_end' => Carbon::now()->addHours(-2)->addMinutes(30),
            'is_upcoming' => false,
            'hourly_rate' => 17,
        ]);

        Session::create([
            'id' => $pastSessionIds[2],
            'tutor_id' => $userIds[2],
            'student_id' => $userIds[1],
            'course_id' => '7',
            'is_in_person' => false,
            'session_time_start' => Carbon::now()->addHours(-7)->addMinutes(30),
            'session_time_end' => Carbon::now()->addHours(-5)->addMinutes(30),
            'is_upcoming' => false,
            'hourly_rate' => 20,
        ]);
    }
}
