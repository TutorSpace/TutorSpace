<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\DB;
use Facades\App\Tag;
use Facades\App\User;
use Facades\App\Transaction;
use Facades\App\TutorRequest;
use Facades\App\Session;

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
            TutorRequest::changeTutorRequestStatusOnTimeout();
            echo "Successfully changed stale tutor request to expired: " . now() . "\n";
        })->everyThirtyMinutes();

        $schedule->call(function () {
            Session::changeSessionStatusOnExpiry();
            echo "Successfully changed stale tutor sessions to expired: " . now() . "\n";
        })->everyMinute();

        $schedule->call(function () {
            User::updateVerifyStatus();
            echo "Successfully update is_tutor_verified: " . now() . "\n";
        })->everyThirtyMinutes();

        $schedule->call(function () {
            Transaction::finalizeInvoice();
            echo "Successfully charge invoices: " . now() . "\n";
        })->everyThirtyMinutes();
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
