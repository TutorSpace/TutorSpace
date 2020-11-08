<?php

use Illuminate\Database\Seeder;

class SessionCancelReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('session_cancel_reasons')->insert([
            'reason' => 'Time Conflict',
        ]);

        DB::table('session_cancel_reasons')->insert([
            'reason' => 'Price is Too High',
        ]);

        DB::table('session_cancel_reasons')->insert([
            'reason' => 'Other',
        ]);
    }
}
