<?php

namespace App\Http\Middleware;

use App\Services\AccessControlService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogActivity
{
    protected $accessControlService;

    public function __construct(AccessControlService $accessControlService)
    {
        $this->accessControlService = $accessControlService;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log if user is authenticated and it's not a GET request (to avoid logging page views)
        if (Auth::check() && $request->method() !== 'GET') {
            $this->logRequest($request);
        }

        return $response;
    }

    private function logRequest(Request $request)
    {
        $action = $this->getActionFromMethod($request->method());
        $module = $this->getModuleFromRoute($request->route());
        $description = $this->getDescriptionFromRequest($request);

        // Don't log sensitive requests
        if ($this->shouldSkipLogging($request)) {
            return;
        }

        ActivityLog::logActivity(
            Auth::id(),
            $action,
            $module,
            $description,
            $this->getOldValues($request),
            $this->getNewValues($request)
        );
    }

    private function getActionFromMethod($method)
    {
        return match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'unknown',
        };
    }

    private function getModuleFromRoute($route)
    {
        if (!$route) {
            return 'unknown';
        }

        $routeName = $route->getName();
        
        if ($routeName) {
            return match(true) {
                str_contains($routeName, 'employee') => 'employee',
                str_contains($routeName, 'payroll') => 'payroll',
                str_contains($routeName, 'leave') => 'leave',
                str_contains($routeName, 'performance') => 'performance',
                str_contains($routeName, 'analytics') => 'analytics',
                str_contains($routeName, 'notifications') => 'notifications',
                str_contains($routeName, 'access-control') => 'access_control',
                str_contains($routeName, 'user') => 'user_management',
                str_contains($routeName, 'role') => 'role_management',
                default => 'general',
            };
        }

        return 'general';
    }

    private function getDescriptionFromRequest(Request $request)
    {
        $routeName = $request->route()->getName();
        $method = $request->method();
        
        if ($routeName) {
            return match(true) {
                str_contains($routeName, 'store') => "Created new record via {$routeName}",
                str_contains($routeName, 'update') => "Updated record via {$routeName}",
                str_contains($routeName, 'delete') => "Deleted record via {$routeName}",
                str_contains($routeName, 'destroy') => "Deleted record via {$routeName}",
                default => "Performed {$method} request on {$routeName}",
            };
        }

        return "Performed {$method} request";
    }

    private function shouldSkipLogging(Request $request)
    {
        // Skip logging for sensitive routes
        $sensitiveRoutes = [
            'login',
            'logout',
            'password',
            'profile',
            'settings',
        ];

        $routeName = $request->route()->getName();
        
        if ($routeName) {
            foreach ($sensitiveRoutes as $sensitiveRoute) {
                if (str_contains($routeName, $sensitiveRoute)) {
                    return true;
                }
            }
        }

        // Skip logging for requests with sensitive data
        $sensitiveData = ['password', 'token', 'secret', 'key'];
        $requestData = $request->all();
        
        foreach ($sensitiveData as $sensitive) {
            if (isset($requestData[$sensitive])) {
                return true;
            }
        }

        return false;
    }

    private function getOldValues(Request $request)
    {
        // For update requests, we might want to capture old values
        // This would require additional logic to fetch the current state
        // For now, return empty array
        return [];
    }

    private function getNewValues(Request $request)
    {
        // Capture request data, but filter out sensitive information
        $data = $request->all();
        
        // Remove sensitive data from logs
        $sensitiveFields = ['password', 'password_confirmation', 'token', 'secret', 'key'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[FILTERED]';
            }
        }

        return $data;
    }
}
