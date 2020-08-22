<?php

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
        DB::table('sessions')->insert([
            'tutor_id' => '2',
            'student_id' => '1',
            'course_id' => '1',
            'date' => Carbon::now(),

            'session_time_start' => Carbon::now()->addHours(2),
            'session_time_end' => Carbon::now()->addHours(3),
        ]);
    }
}
