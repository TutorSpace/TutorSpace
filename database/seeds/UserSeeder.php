<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'student',
            'last_name' => 'tester',
            'email' => 'student@usc.edu',
            'is_tutor' => 0,
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tutor',
            'last_name' => 'tester',
            'email' => 'tutor@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 1,
            'gpa' => '3.70',
            'hourly_rate' => '15',
            'school_year_id' => 1,
            'password' => Hash::make('password')
        ]);

        $userTags = [
            [
                'user_id' => 1,
                'tag_id' => 2
            ],[
                'user_id' => 1,
                'tag_id' => 3
            ],[
                'user_id' => 2,
                'tag_id' => 17
            ],[
                'user_id' => 1,
                'tag_id' => 16
            ],[
                'user_id' => 2,
                'tag_id' => 15
            ],[
                'user_id' => 1,
                'tag_id' => 14
            ]
        ];
        DB::table('tag_user')->insert($userTags);
    }
}
