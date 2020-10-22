<?php

use Illuminate\Database\Seeder;

class MinorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('minors')->insert([
            'minor' => 'Computer Science'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Business Administration'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Mathematics'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Physics'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Design'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Engineering'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Communication'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Music'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Education'
        ]);

        DB::table('minors')->insert([
            'minor' => 'Psychology'
        ]);
    }
}
