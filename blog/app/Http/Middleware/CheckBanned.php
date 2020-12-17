<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->user_type == User::ROLE_BANNED) {
            auth()->logout();
            $message = 'Your account has been suspended. Please contact administrator.';
            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
