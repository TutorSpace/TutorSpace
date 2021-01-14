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
        // $faker = Faker\Factory::create();
        // for($i = 0; $i < 150; $i++) {
        //     do {
        //         $from = rand(1, 4);
        //         $to = rand(1, 4);
        //     } while($from == $to);

        //     Message::create([
        //         'from' => $from,
        //         'to' => $to,
        //         'message' => $faker->sentence,
        //         'created_at' => Carbon::now()
        //     ]);
        // }

        // for($i = 1; $i <= 4; $i++) {
        //     for($j = $i + 1; $j <= 4; $j++) {
        //         Chatroom::create([
        //             'user_id_1' => $i,
        //             'user_id_2' => $j,
        //             'creator_user_id' => $i
        //         ]);
        //     }
        // }


    }
}
