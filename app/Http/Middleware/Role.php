<?php

namespace App\Http\Middleware;

use Closure;
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
	public function handle($request, Closure $next, $role)
	{
		if (Auth::check()) {
			// Pass only super admin
			if ($request->user()->isSuperAdmin() && strtolower($role) === 'super') {
				return $next($request);
			}
			
			// Pass only Admin and super admin
			if (($request->user()->isAdmin() || $request->user()->isSuperAdmin()) && strtolower($role) === 'admin') {
				return $next($request);
			}
			
			// Pass moderators admins and super admins
			if ($request->user()->isBlessed() && strtolower($role) === 'moderator') {
				return $next($request);
			}
		}
		
		// Not passed
		return response()->json(['message' => 'You don\'t have ' . $role . ' role.'], 401);
	}
}
