<?php

// /////////////////////////////////////////////////////////////////////////////
// PLEASE DO NOT RENAME OR REMOVE ANY OF THE CODE BELOW.
// YOU CAN ADD YOUR CODE TO THIS FILE TO EXTEND THE FEATURES TO USE THEM IN YOUR WORK.
// /////////////////////////////////////////////////////////////////////////////

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $expectedToken = Config::get('app.bearer_token');

        if ($request->hasHeader('Authorization')) {
            $token = $request->bearerToken();

            if ($token && hash_equals($expectedToken, $token)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
