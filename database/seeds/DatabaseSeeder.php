<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TutorLevelSeeder::class,
            MajorSeeder::class,
            SchoolYearSeeder::class,
            TagSeeder::class,
            CourseSeeder::class,
            UserSeeder::class,
            ReportReasonSeeder::class,
            TutorSessionSeeder::class,
            ReviewSeeder::class,
            AvailableTimeSeeder::class,

            PostTypeSeeder::class,
            PostSeeder::class,
            ReplySeeder::class,
            ViewCntSeeder::class,

        ]);
    }
}
