<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'email' => 'shuaiqin@usc.edu',
        ]);

        DB::table('admins')->insert([
            'email' => 'lihanzhu@usc.edu',
        ]);

        DB::table('admins')->insert([
            'email' => 'huan773@usc.edu',
        ]);

        DB::table('admins')->insert([
            'email' => 'yidieling@gmail.com',
        ]);

        DB::table('admins')->insert([
            'email' => 'zhongwez@usc.edu',
        ]);

    }
}
