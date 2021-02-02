<?php

namespace App\Console;

use App\Session;
use Facades\App\Tag;

use App\TutorRequest;
use Facades\App\User;
use Facades\App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
            Log::debug("Successfully updated trending tags at: " . now() . "\n");
        })->everyThirtyMinutes();
        // })->everyMinute();

        $schedule->call(function () {
            User::clearTutorAvailableTime();
            Log::debug("Successfully removed stale available time of tutors at: " . now() . "\n");
        })->daily();
        // })->everyMinute();

        $schedule->call(function () {
            TutorRequest::changeTutorRequestStatusOnTimeout();
            Log::debug("Successfully changed stale tutor request to expired: " . now() . "\n");
        })->everyThirtyMinutes();
        // })->everyMinute();

        $schedule->call(function () {
            Session::changeSessionStatusOnExpiry();
            Log::debug("Successfully changed stale tutoring sessions to expired: " . now() . "\n");
        })->everyThirtyMinutes();
        // })->everyMinute();

        $schedule->call(function () {
            User::updateVerifyStatus();
            Log::debug("Successfully update is_tutor_verified: " . now() . "\n");
        })->everyThirtyMinutes();
        // })->everyMinute();

        // finalize means invoice_status from draft => open, may not be paid yet
        $schedule->call(function () {
            // input: minutes after session to finalize
            Transaction::finalizeInvoice(0);
            Log::debug("Successfully finalize invoices: " . now() . "\n");
        })->everyThirtyMinutes();
        // })->everyMinute();

        // ask users to pay their bills!!!
        $schedule->call(function () {
            // send one invoice after 24 hours since last_updated on database transaction table
            Transaction::sendUnpaidInvoices(24);
            Log::debug("Successfully send emails to users that haven't paid their invoices: " . now() . "\n");
        })->twiceDaily(1, 12);
        // })->everyMinute();

        // notify the users that they have an upcoming session
        $schedule->call(function () {
            Session::notifyUpcomingSessions();
            Log::debug("Successfully notify the users about their upcoming sessions: " . now() . "\n");
        })->hourly();
        // })->everyMinute();

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
