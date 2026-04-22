<?php
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureHrOrAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
 
        if (! $user) {
            return redirect()->route('login');
        }
 
        if (! in_array($user->role, ['admin', 'hr_manager'])) {
            abort(403, 'HR Manager or Administrator access required.');
        }
 
        return $next($request);
    }
}
 