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
			if ($request->user()->isAdmin() && strtolower($role) === 'admin') {
				return $next($request);
				
			}
			if (($request->user()->isModerator() || $request->user()->isAdmin()) && strtolower($role) === 'moderator') {
				return $next($request);
			}
		}
		
		return response()->json(['message' => 'You don\'t have ' . $role . ' role.'], 500);
	}
}
