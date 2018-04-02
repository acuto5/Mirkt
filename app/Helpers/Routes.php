<?php
function getAllRoutes()
{
    $routes = [];
    
    foreach (Illuminate\Support\Facades\Route::getRoutes()->getRoutes() as $route) {
        $routeName            = $route->getName();
        $routeMiddlewareArray = $route->middleware();
        
        if (isset($routeName)) { // Send routes only with route name
            if (in_array('role:super', $routeMiddlewareArray)) {
                if(Auth::check() && Auth::user()->isSuperAdmin()) { // If Super Admin
                    $routes[$routeName] = route($routeName);
                }
            } elseif (in_array('role:admin', $routeMiddlewareArray)) {
                if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())) { // If Admin || SuperAdmin
                    // Save as full url
                    $routes[$routeName] = route($routeName);
                }
            } elseif (in_array('role:moderator', $routeMiddlewareArray)) {
                if (Auth::check() && Auth::user()->isBlessed()) { // If Moderator || Admin || SuperAdmin
                    // Save as full url
                    $routes[$routeName] = route($routeName);
                }
            } elseif (in_array('auth', $routeMiddlewareArray)) { // User login
                // Auth routes
                $routes[$routeName] = route($routeName);
            }
             elseif (in_array('guest', $routeMiddlewareArray)) { // Guest
                // Guest routes
                 if(!Auth::check()) {
                     $routes[$routeName] = route($routeName);
                 }
            } else {
                // Save as full url
                $routes[$routeName] = route($routeName); // All who left
            }
        }
    }
    
    return json_encode($routes);
}