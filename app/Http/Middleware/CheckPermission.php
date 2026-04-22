<?php

namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
 
        if (! $user) {
            return redirect()->route('login');
        }
 
        // Admin always passes
        if ($user->role === 'admin') {
            return $next($request);
        }
 
        // Check role_permissions table
        $allowed = \DB::table('role_permissions')
            ->where('role', $user->role)
            ->where('permission', $permission)
            ->where('allowed', true)
            ->exists();
 
        if (! $allowed) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403, "You don't have permission to perform this action.");
        }
 
        return $next($request);
    }
}
