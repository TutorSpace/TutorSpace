<?php

use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('majors')->insert([
            'major' => 'Computer Science'
        ]);

        DB::table('majors')->insert([
            'major' => 'Business Administration'
        ]);

        DB::table('majors')->insert([
            'major' => 'Mathematics'
        ]);

        DB::table('majors')->insert([
            'major' => 'Physics'
        ]);

        DB::table('majors')->insert([
            'major' => 'Design'
        ]);

        DB::table('majors')->insert([
            'major' => 'Engineering'
        ]);

        DB::table('majors')->insert([
            'major' => 'Communication'
        ]);

        DB::table('majors')->insert([
            'major' => 'Music'
        ]);

        DB::table('majors')->insert([
            'major' => 'Education'
        ]);

        DB::table('majors')->insert([
            'major' => 'Psychology'
        ]);
    }
}
