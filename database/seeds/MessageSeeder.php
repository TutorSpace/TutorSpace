<?php

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
        $faker = Faker\Factory::create();
        for($i = 0; $i < 150; $i++) {
            do {
                $from = rand(1, 5);
                $to = rand(1, 5);
            } while($from == $to);

            DB::table('messages')->insert([
                'from' => $from,
                'to' => $to,
                'message' => $faker->sentence,
                'created_at' => Carbon::now()
            ]);
        }
    }
}
