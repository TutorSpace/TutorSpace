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
        // adding tags
        $command = escapeshellcmd('python python_web_scraping/main.py');
        $output = shell_exec($command);

        $this->call([
            TutorLevelSeeder::class,
            SchoolYearSeeder::class,
            UserSeeder::class,
            ReportReasonSeeder::class,
            ReviewSeeder::class,
            AvailableTimeSeeder::class,
            UpcomingSessionSeeder::class,

            PostTypeSeeder::class,
            PostSeeder::class,
            ReplySeeder::class,
            ViewCntSeeder::class,

        ]);
    }
}
