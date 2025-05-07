<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard($guards)->check()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access that page.');
        }

        return $next($request);
    }
} 