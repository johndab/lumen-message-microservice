<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{

    /**
     *
     * Verify application token
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $header = $request->header('App-Token');
        $valid = env('APP_TOKEN', '123');

        if($header === $valid) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
