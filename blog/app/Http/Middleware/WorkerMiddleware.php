<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class WorkerMiddleware
{
    protected $auth;
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->getUser()->user_type !== User::ROLE_WORKER) {
            abort(403, 'Unauthorized action');
        }

        return $next($request);
    }
}
