<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AvailableTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;

        DB::table('available_times')->insert([
            'user_id' => $userIds[2],
            'available_time_start' => Carbon::now()->subHours(24 + 4),
            'available_time_end' => Carbon::now()->addHours(24 + 7)
        ]);

        DB::table('available_times')->insert([
            'user_id' => $userIds[3],
            'available_time_start' => Carbon::now()->addHours(24 + 1),
            'available_time_end' => Carbon::now()->addHours(24 + 2)
        ]);

        DB::table('available_times')->insert([
            'user_id' => $userIds[7],
            'available_time_start' => Carbon::now()->addHours(2),
            'available_time_end' => Carbon::now()->addHours(3)
        ]);
    }
}
