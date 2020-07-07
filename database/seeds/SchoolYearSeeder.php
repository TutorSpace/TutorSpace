<?php

use Illuminate\Database\Seeder;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('school_years')->insert([
            'school_year' => 'Freshman'
        ]);

        DB::table('school_years')->insert([
            'school_year' => 'Sophomore'
        ]);

        DB::table('school_years')->insert([
            'school_year' => 'Junior'
        ]);

        DB::table('school_years')->insert([
            'school_year' => 'Senior'
        ]);

        DB::table('school_years')->insert([
            'school_year' => 'Graduate'
        ]);
    }
}
