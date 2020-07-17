<?php

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            'star_rating' => 4,
            'reviewer_id' => 1,
            'reviewee_id' => 2,
            'review' => 'This is testing review 1.'
        ]);

        DB::table('reviews')->insert([
            'star_rating' => 3,
            'reviewer_id' => 1,
            'reviewee_id' => 2,
            'review' => 'This is testing review 2.'
        ]);

        DB::table('reviews')->insert([
            'star_rating' => 4,
            'reviewer_id' => 1,
            'reviewee_id' => 2,
            'review' => 'This is testing review 3.'
        ]);

        DB::table('reviews')->insert([
            'star_rating' => 4,
            'reviewer_id' => 1,
            'reviewee_id' => 3,
            'review' => 'This is testing review 4.'
        ]);
    }
}
