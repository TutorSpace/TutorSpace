<?php

use App\Message;
use App\Chatroom;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $userIds = DatabaseSeeder::$userIds;

        // $faker = Faker\Factory::create();
        // for($i = 0; $i < 150; $i++) {
        //     do {
        //         $from = rand(1, 10);
        //         $to = rand(1, 10);
        //     } while($from == $to);

        //     Message::create([
        //         'from' => $userIds[$from],
        //         'to' => $userIds[$to],
        //         'message' => $faker->sentence,
        //         'created_at' => Carbon::now()
        //     ]);
        // }

        // for($i = 1; $i <= 10; $i++) {
        //     for($j = $i + 1; $j <= 10; $j++) {
        //         Chatroom::create([
        //             'user_id_1' => $userIds[$i],
        //             'user_id_2' => $userIds[$j],
        //             'creator_user_id' => $userIds[$i]
        //         ]);
        //     }
        // }


    }
}
