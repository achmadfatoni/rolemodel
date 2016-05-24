<?php

namespace Klsandbox\RoleModel\Http\Middleware;

use App;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class RoleMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $roleNames)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        foreach (explode('+', $roleNames) as $role) {
            if ($this->auth->user()->access()->{$role}) {
                return $next($request);
            }
        }

        App::abort(403, 'Unauthorized action.');
    }
}
