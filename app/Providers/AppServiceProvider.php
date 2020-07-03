<?php

namespace App\Providers;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // print out the raw sql (use view page source to see the results)
        DB::listen(function($query) {
            // echo "<p>{$query->sql}</p>";
        });
    }
}
