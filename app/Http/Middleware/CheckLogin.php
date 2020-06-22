<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // check whether the use is logged in. If not, the user will redirect to the login page
        if(Auth::check()) {
            return $next($request);
        }
        else {
            return redirect()->route('index')->with([
                'errorMsg' => 'Please log into your account first!'
            ]);
        }

    }
}
