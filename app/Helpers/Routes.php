<?php
function getAllRoutes()
{
	$routes = [];
	
	foreach (\Route::getRoutes()->getIterator() as $route) {
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
			} else {
				// Save as full url
				$routes[$routeName] = route($routeName);
			}
		}
	}
	
	return json_encode($routes);
}