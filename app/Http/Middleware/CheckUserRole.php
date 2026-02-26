<?php

namespace App\Http\Middleware;

use App\Enum\UserRole;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = User::where('id', Auth::id())->first();

        if ($user && $request->is('login')) {
            return redirect('/');
        }

        if (!$user) {
            return redirect()->route('login')->with('error', 'You need to log in to access this resource.');
        }
        
        // Allow access if wildcard is specified
        if (in_array('*', $roles) || in_array('Any', $roles)) {
            return $next($request);
        }

        // Allow access if user is SuperAdmin (for admin routes)
        if ($user->role === 'SuperAdmin' && $request->is('admin/*')) {
            return $next($request);
        }

        try {
            $requiredRoles = array_map(fn($role) => UserRole::from($role), $roles);
        } catch (Exception $e) {
            return response()->json(['error' => "Invalid role specified: {$e->getMessage()}."], 403);
        }

        try {
            $userRole = UserRole::from($user->role); // Get the user's role
        } catch (Exception $e) {
            return response()->json(['error' => 'User role is invalid or undefined.'], 500);
        }

        if (!in_array($userRole, $requiredRoles, true)) {
            return response()->json([
                'error' => "You don't have any of the required roles (" . implode(', ', array_map(fn($role) => $role->value, $requiredRoles)) . ") to access this resource."
            ], 403);
        }
        
        return $next($request);
    }
}
