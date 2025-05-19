<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the user's role
        $userRole = Auth::user()->role;

        // If the user has any of the required roles, allow access
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // If the user doesn't have the required role, redirect with an error
        return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
    }
}
