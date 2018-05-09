<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * @param          $request
     * @param \Closure $next
     * @param string   $role
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::check()) {
            switch (strtolower($role)) {
                case 'super':
                    return $request->user()->isSuperAdmin() ? $next($request) : $this->errorResponse($role);
                case 'admin':
                    return ($request->user()->isAdmin() || $request->user()->isSuperAdmin()) ?
                        $next($request) : $this->errorResponse($role);
                case 'moderator':
                    return $request->user()->isBlessed() ? $next($request) : $this->errorResponse($role);
                default:
                    return $this->errorResponse($role);
            }
        }

        // Not passed
        return $this->errorResponse($role);
    }

    private function errorResponse(string $role): JsonResponse
    {
        return response()->json(['message' => 'You don\'t have ' . $role . ' role.'], 401);
    }
}
