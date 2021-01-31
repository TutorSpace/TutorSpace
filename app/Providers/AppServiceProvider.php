<?php

namespace App\Providers;

use DB;
use Laravel\Telescope\Telescope;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Payment\StripeApiController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Telescope::ignoreMigrations();

        // customized
        $this->app->bind(StripeApiController::class, function() {
            return new StripeApiController();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // print out the raw sql (use view page source to see the results)
        DB::listen(function($query) {
            // echo "<p>{$query->sql}</p>";
        });

        Paginator::defaultView('pagination.paginate');
        Paginator::defaultSimpleView('pagination.simple');

        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }
        // URL::forceScheme('https');
    }
}
