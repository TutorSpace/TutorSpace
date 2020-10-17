<?php

use Illuminate\Database\Seeder;

class InvalidUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'student@usc.edu',
            'invalid_reason' => 'This user did not complete the process when he wants to register for a tutor account from a student account.',
            'redirect_route_name' => 'home.profile'
        ]);
    }
}
