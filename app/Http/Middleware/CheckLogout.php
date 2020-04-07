<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLogout
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
        // check whether the use is not logged in. If not, the user will redirect to the home page
        if(!Auth::check()) {
            return $next($request);
        }
        else {
            $user = Auth::user();
            if($user->is_tutor) {
                return redirect()->route('home_tutor');
            }
            else {
                return redirect()->route('home_student');
            }
            
        }
    }
}
