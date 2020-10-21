<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuspended
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
        if(auth()->check() && auth()->user()->status && auth()->user()->status == "suspended"){
            $message = "Your account has been suspended. Please contact the administrator.";
            auth()->logout();
            return redirect()->route('login')->withErrors($message);
        }elseif(auth()->check() && auth()->user()->status && auth()->user()->status == "deleted"){
            $message = "Your account has been deleted. Please contact the administrator.";
            auth()->logout();
            return redirect()->route('login')->withErrors($message);
        }
        return $next($request);
    }
}
