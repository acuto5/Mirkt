<?php


//Route::get('/test', 'testas@getRoutes');

require_once 'web-routes/auth.php';                	// Auth
require_once 'web-routes/tags.php';                	// Tags
require_once 'web-routes/categories.php';        	// Categories
require_once 'web-routes/sub-categories.php';    	// Sub categories
require_once 'web-routes/articles.php';        		// Articles
require_once 'web-routes/users.php';                // User


// Allow access files from storage
Route::match(['get'], '/storage/{fileName}', function ($fileName){
	return response(file_get_contents('./storage/' . $fileName));
})->where(['fileName' => '.*']);

/**************************************/
/* No GET routes below this will work */
/**************************************/
Route::match(['get'], '{all}', function () {
	return view('app');
})->where(['all' => '.*']); // Need regex filter witch data can be passed

