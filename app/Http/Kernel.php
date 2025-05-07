<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guard = $guards[0] ?? null; // Get the first guard or use default

        if (Auth::guard($guard)->check()) {
            return redirect()->route('home')->with('error', 'You are already logged in.');
        }

        return $next($request);
    }
}
