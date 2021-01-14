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
        // Session::create([
        //     'tutor_id' => '3',
        //     'student_id' => '1',
        //     'course_id' => '1',
        //     'is_in_person' => true,
        //     'session_time_start' => Carbon::now()->addHours(-2),
        //     'session_time_end' => Carbon::now()->addHours(-1),
        //     'is_upcoming' => false,
        //     'hourly_rate' => 14,
        // ]);

        // Session::create([
        //     'tutor_id' => '3',
        //     'student_id' => '2',
        //     'course_id' => '5',
        //     'is_in_person' => false,
        //     'session_time_start' => Carbon::now()->addHours(-3)->addMinutes(30),
        //     'session_time_end' => Carbon::now()->addHours(-2)->addMinutes(30),
        //     'is_upcoming' => false,
        //     'hourly_rate' => 17,
        // ]);

        // Session::create([
        //     'tutor_id' => '3',
        //     'student_id' => '2',
        //     'course_id' => '7',
        //     'is_in_person' => false,
        //     'session_time_start' => Carbon::now()->addHours(-7)->addMinutes(30),
        //     'session_time_end' => Carbon::now()->addHours(-5)->addMinutes(30),
        //     'is_upcoming' => false,
        //     'hourly_rate' => 20,
        // ]);
    }
}
