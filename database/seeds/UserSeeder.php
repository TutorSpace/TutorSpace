<?php

use Carbon\Carbon;
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
            'first_name' => 'Shuaiqing',
            'last_name' => 'Luo',
            'email' => 'shuaiqin@usc.edu',
            'is_tutor' => 0,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('23')
        ]);

        DB::table('users')->insert([
            'first_name' => 'student',
            'last_name' => 'tester',
            'email' => 'student@usc.edu',
            'is_tutor' => 0,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('23')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tutor',
            'last_name' => 'tester',
            'email' => 'tutor@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 1,
            'second_major_id' => 3,
            'gpa' => '3.70',
            'hourly_rate' => '15',
            'school_year_id' => 1,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('173')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tester',
            'last_name' => '1',
            'email' => 'tester1@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 3,
            'gpa' => '3.35',
            'hourly_rate' => '25',
            'school_year_id' => 1,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('103')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tester',
            'last_name' => '2',
            'email' => 'tester2@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 2,
            'gpa' => '3.90',
            'hourly_rate' => '25',
            'school_year_id' => 2,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('199')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tester',
            'last_name' => '3',
            'email' => 'tester3@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 3,
            'gpa' => '2.85',
            'hourly_rate' => '22',
            'school_year_id' => 3,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('143')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tester',
            'last_name' => '4',
            'email' => 'tester4@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 4,
            'gpa' => '3.55',
            'hourly_rate' => '25',
            'school_year_id' => 4,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('11')
        ]);

        DB::table('users')->insert([
            'first_name' => 'tester',
            'last_name' => '5',
            'email' => 'tester5@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 8,
            'gpa' => '3.13',
            'hourly_rate' => '35',
            'school_year_id' => 3,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('193')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Nate',
            'last_name' => 'Huang',
            'email' => 'huan773@usc.edu',
            'is_tutor' => 0,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('23')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Nate',
            'last_name' => 'Huang',
            'email' => 'huan773@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 8,
            'gpa' => '3.13',
            'hourly_rate' => '35',
            'school_year_id' => 3,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('193')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Lihan',
            'last_name' => 'Zhu',
            'email' => 'lihanzhu@usc.edu',
            'is_tutor' => 0,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now()->subHours('23')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Lihan',
            'last_name' => 'Zhu',
            'email' => 'lihanzhu@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 8,
            'gpa' => '3.13',
            'hourly_rate' => '35',
            'school_year_id' => 3,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('193')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Shuaiqing',
            'last_name' => 'Luo',
            'email' => 'shuaiqin@usc.edu',
            'is_tutor' => 1,
            'first_major_id' => 14,
            'gpa' => '3.33',
            'hourly_rate' => '32',
            'school_year_id' => 4,
            'password' => Hash::make('password'),
            'is_tutor_verified' => true,
            'created_at' => Carbon::now()->subHours('193')
        ]);



        $userTags = [
            [
                'user_id' => 1,
                'tag_id' => 2
            ],[
                'user_id' => 1,
                'tag_id' => 3
            ],[
                'user_id' => 1,
                'tag_id' => 1
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
            ],[
                'user_id' => 2,
                'tag_id' => 1
            ]
        ];
        DB::table('tag_user')->insert($userTags);

        $courseUsers = [
            [
                'user_id' => 1,
                'course_id' => 2
            ],
            [
                'user_id' => 2,
                'course_id' => 2
            ],[
                'user_id' => 2,
                'course_id' => 4
            ],[
                'user_id' => 2,
                'course_id' => 5
            ],[
                'user_id' => 2,
                'course_id' => 6
            ],[
                'user_id' => 2,
                'course_id' => 7
            ],[
                'user_id' => 2,
                'course_id' => 8
            ],[
                'user_id' => 2,
                'course_id' => 9
            ],[
                'user_id' => 3,
                'course_id' => 3
            ],[
                'user_id' => 4,
                'course_id' => 5
            ],[
                'user_id' => 4,
                'course_id' => 6
            ],[
                'user_id' => 5,
                'course_id' => 1
            ],[
                'user_id' => 6,
                'course_id' => 3
            ],[
                'user_id' => 7,
                'course_id' => 52
            ],[
                'user_id' => 8,
                'course_id' => 65
            ],[
                'user_id' => 9,
                'course_id' => 55
            ],[
                'user_id' => 10,
                'course_id' => 45
            ],[
                'user_id' => 11,
                'course_id' => 35
            ],[
                'user_id' => 12,
                'course_id' => 25
            ],[
                'user_id' => 13,
                'course_id' => 15
            ]
        ];
        DB::table('course_user')->insert($courseUsers);
    }
}
