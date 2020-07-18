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
        DB::table('available_times')->insert([
            'user_id' => '2',
            'available_time_start' => Carbon::now()->addHours(1),
            'available_time_end' => Carbon::now()->addHours(2)
        ]);

        DB::table('available_times')->insert([
            'user_id' => '3',
            'available_time_start' => Carbon::now()->addHours(1),
            'available_time_end' => Carbon::now()->addHours(2)
        ]);

        DB::table('available_times')->insert([
            'user_id' => '4',
            'available_time_start' => Carbon::now()->addHours(1),
            'available_time_end' => Carbon::now()->addHours(2)
        ]);

        DB::table('available_times')->insert([
            'user_id' => '4',
            'available_time_start' => Carbon::now()->addHours(2),
            'available_time_end' => Carbon::now()->addHours(3)
        ]);
    }
}
