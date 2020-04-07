<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLoginStudent
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
            $user = Auth::user();
            if(!$user->is_tutor)
                return $next($request);
            return redirect()->route('login');
        }
        else {
            return redirect()->route('login');
        }
    }
}
