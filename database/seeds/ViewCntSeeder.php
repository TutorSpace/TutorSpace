<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ViewCntSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = DatabaseSeeder::$userIds;
        $postIds = DatabaseSeeder::$postIds;

        // generate post views
        for($i = 0; $i < 1000; $i++) {
            DB::table('views')->insert([
                'viewable_type' => 'App\Post',
                'viewable_id' => $userIds[rand(0, 11)],
                'viewed_at' => Carbon::now()->subDays($i % 3 == 0 ? 0 : rand(1, 30))
            ]);
        }

        // generate profile views
        for($i = 0; $i < 1000; $i++) {
            DB::table('views')->insert([
                'viewable_type' => 'App\User',
                'viewable_id' => $userIds[rand(1, 7)],
                'viewed_at' => Carbon::now()->subDays($i % 3 == 0 ? 0 : rand(1, 30))
            ]);
        }

    }
}
