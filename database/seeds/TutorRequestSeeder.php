<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TutorRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;
        DB::table('tutor_requests')->insert([
            'tutor_id' => $userIds[4],
            'student_id' => $userIds[0],
            'course_id' => '101',
            'session_time_start' => Carbon::now()->addMinutes(20),
            'session_time_end' => Carbon::now()->addMinutes(80),
            'is_in_person' => true,
            'hourly_rate' => User::find($userIds[4])->hourly_rate,
        ]);

        DB::table('tutor_requests')->insert([
            'tutor_id' => $userIds[4],
            'student_id' => $userIds[0],
            'course_id' => '501',
            'session_time_start' => Carbon::now()->addHours(2)->addMinutes(20),
            'session_time_end' => Carbon::now()->addHours(3)->addMinutes(40),
            'is_in_person' => true,
            'hourly_rate' => User::find($userIds[4])->hourly_rate,
        ]);
    }
}
