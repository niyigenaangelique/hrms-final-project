<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // If no specific roles required, just check if user is authenticated
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            // If wildcard role is specified, allow any authenticated user
            if ($role === '*' || rtrim($role, '*') === '*') {
                return $next($request);
            }
            
            // Remove any trailing asterisks from role names
            $role = rtrim($role, '*');
            
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // If user doesn't have required role, redirect to unauthorized page or home
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }
}
