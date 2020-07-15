<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'course' => 'CSCI 104'
        ]);

        DB::table('courses')->insert([
            'course' => 'CSCI 201'
        ]);

        DB::table('courses')->insert([
            'course' => 'MATH 226'
        ]);

        DB::table('courses')->insert([
            'course' => 'PhyS 151'
        ]);

        DB::table('courses')->insert([
            'course' => 'MATH 304'
        ]);

        DB::table('courses')->insert([
            'course' => 'BUAD 304'
        ]);

        DB::table('courses')->insert([
            'course' => 'EE 109'
        ]);

        DB::table('courses')->insert([
            'course' => 'WRIT 150'
        ]);
    }
}
