<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    // 13 users in total
    public static $userIds = [
        '04c9b829-f027-4ff2-a4ea-0410ba684134',
        '1455f287-15b5-4c3b-91fa-9f4569a20db8',
        '20328b5f-3e02-4d7c-86e7-bef3e5a9314c',
        '37aea9af-752e-4c8b-a2b8-7a78f569cbb4',
        '3bf9c777-0bba-4a45-9e71-ffed8327f42a',
        '61da48e2-a9bc-4c84-bbb2-b3ca7d3b314d',
        '68f492fe-bf5b-409f-9659-9d92cd5f5fb7',
        '7623a2b0-b334-4bb6-8d24-f9d0e3094022',
        '7bc4e474-44e5-449c-82ad-c0a5779440a8',
        '8742af85-3299-4e98-b2b1-1ad6ca5848ef',
        '88ed8e24-e13f-4565-be23-a0b5f202f9ee',
        '8fb7fd37-514f-48bb-bdd6-fff8d9e878c5',
        '9acedcf4-a71b-42a0-9f4c-9e0cfe5e1fbe',
        'b6198a50-4a86-4f87-b528-a317d9973e45',
        'eeab4380-9709-4f20-bf7d-e84c1cb38b94',
        'f6bf6b53-bbfa-49d8-9efd-0789030f05a0'
    ];

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
            AdminSeeder::class,
            ReportReasonSeeder::class,
            AvailableTimeSeeder::class,
            UpcomingSessionSeeder::class,
            PastSessionSeeder::class,
            ReviewSeeder::class,

            PostTypeSeeder::class,
            PostSeeder::class,
            ReplySeeder::class,
            ViewCntSeeder::class,
            TutorRequestSeeder::class,
            SessionCancelReasonSeeder::class,
            MessageSeeder::class,
            VerifiedCourseSeeder::class,
        ]);
    }
}
