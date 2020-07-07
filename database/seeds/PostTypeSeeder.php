<?php

use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_types')->insert([
            'post_type' => 'Question'
        ]);

        DB::table('post_types')->insert([
            'post_type' => 'Note'
        ]);
    }
}
