<?php

use App\Session;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UpcomingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;

        // Session::create([
        //     'tutor_id' => $userIds[4],
        //     'student_id' => $userIds[1],
        //     'course_id' => '1',
        //     'is_in_person' => true,
        //     'session_time_start' => Carbon::now()->addHours(1),
        //     'session_time_end' => Carbon::now()->addHours(2),
        //     'hourly_rate' => 14,
        // ]);
    }
}
