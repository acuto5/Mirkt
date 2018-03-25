<?php
function getAllRoutes()
{
	$routes = [];
	
	foreach (Illuminate\Support\Facades\Route::getRoutes()->getRoutes() as $route) {
		$routeName            = $route->getName();
		$routeMiddlewareArray = $route->middleware();
        
        if (isset($routeName)) { // Send routes only with route name
			if (in_array('role:admin', $routeMiddlewareArray)) { // If Admin
				if (Auth::check() && Auth::user()->isAdmin()) {
					// Save as full url
					$routes[$routeName] = route($routeName);
					continue;
				}
			} elseif (in_array('role:moderator', $routeMiddlewareArray)) { // If moderator
				if (Auth::check() && (Auth::user()->isModerator() || Auth::user()->isAdmin())) {
					// Save as full url
					$routes[$routeName] = route($routeName);
					continue;
				}
			} elseif (in_array('auth', $routeMiddlewareArray)) {
				// Auth routes
				if (Auth::check()) {
					$routes[ $routeName ] = route($routeName);
					continue;
				}
			} elseif (in_array('guest', $routeMiddlewareArray)) {
				// Guest routes
				if (!Auth::check()) {
					$routes[ $routeName ] = route($routeName);
				}
			} else {
				// Save as full url
				$routes[ $routeName ] = route($routeName);
			}
		}
	}
	
	return json_encode($routes);
}