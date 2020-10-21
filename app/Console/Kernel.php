<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Facades\App\Tag;
use Facades\App\User;
use Facades\App\Tutor_request;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Tag::updateTrendingTags();
            echo "Successfully updated trending tags at: " . now() . "\n";
        })->everyThirtyMinutes();

        $schedule->call(function () {
            User::clearTutorAvailableTime();
            echo "Successfully removed stale available time of tutors at: " . now() . "\n";
        })->daily();

        $schedule->call(function () {
            Tutor_request::changeTutorRequestStatusOnTimeout();
            echo "cSuccessfully changed stale tutor sessions to expired: " . now() . "\n";
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
