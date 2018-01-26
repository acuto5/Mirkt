<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class Testas extends Controller
{
	public static function getRoutes()
	{
		$routes = collect();
		
		foreach (\Route::getRoutes()->getIterator() as $route) {
			$routeName            = $route->getName();
			$routeMiddlewareArray = $route->middleware();
			
			if (isset($routeName)) { // Send routes only with route name
				if (in_array('role:admin', $routeMiddlewareArray)) { // If Admin
					if (Auth::check() && Auth::user()->isAdmin()) {
						$routes->push([$route->getName() => $route->uri()]);
						continue;
					}
				} elseif (in_array('role:moderator', $routeMiddlewareArray)) { // If moderator
					if (Auth::check() && (Auth::user()->isModerator() || Auth::user()->isAdmin())) {
						$routes->push([$route->getName() => $route->uri()]);
						continue;
					}
				}
				
				$routes->push([$routeName => $route->uri()]);
			}
		}
		
		return json_encode($routes->all());
	}
}
