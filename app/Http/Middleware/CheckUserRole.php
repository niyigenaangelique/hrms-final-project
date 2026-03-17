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
            // Check if roles are already enum instances, if not convert them
            $requiredRoles = [];
            foreach ($roles as $role) {
                if ($role instanceof UserRole) {
                    $requiredRoles[] = $role;
                } else {
                    $requiredRoles[] = UserRole::from($role);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => "Invalid role specified: {$e->getMessage()}."], 403);
        }

        try {
            // Check if user's role is already a UserRole enum instance
            if ($user->role instanceof UserRole) {
                $userRole = $user->role;
            } else {
                $userRole = UserRole::from($user->role);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'User role is invalid or undefined.'], 500);
        }

        // Convert both to values for comparison
        $userRoleValue = $userRole->value;
        $requiredRoleValues = array_map(fn($role) => $role->value, $requiredRoles);

        if (!in_array($userRoleValue, $requiredRoleValues, true)) {
            return response()->json([
                'error' => "You don't have any of the required roles (" . implode(', ', $requiredRoleValues) . ") to access this resource."
            ], 403);
        }
        
        return $next($request);
    }
}
