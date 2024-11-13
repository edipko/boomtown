<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has 'is_admin' attribute set
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirect to the home page if not an admin
        return redirect('/');
    }
}
