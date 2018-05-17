<?php
// Auth routes
require 'web-routes/auth/auth.php';

// User
require 'web-routes/user/user.php';

// Home routes
require 'web-routes/home/home.php';

//Info
require 'web-routes/info/contacts.php';
require 'web-routes/info/website-info.php';

//Tags routes
require 'web-routes/tags/tags.php';
require 'web-routes/tags/tag-articles.php';

// Categories routes
require 'web-routes/categories/categories.php';
require 'web-routes/categories/category-level.php';
require 'web-routes/categories/category-articles.php';
require 'web-routes/categories/categories-with-sub-categories.php';

// Sub-category routes
require 'web-routes/sub-categories/sub-categories.php';
require 'web-routes/sub-categories/sub-category-articles.php';
require 'web-routes/sub-categories/sub-categories-levels.php';

// Articles
require 'web-routes/articles/articles.php';
require 'web-routes/articles/articles-draft.php';
require 'web-routes/articles/articles-published.php';
require 'web-routes/articles/articles-search-draft.php';
require 'web-routes/articles/articles-search-published.php';
require 'web-routes/articles/article-mark-as-draft.php';
require 'web-routes/articles/article-mark-as-published.php';

// Allow access files from storage
Route::match(['get'], '/storage/{fileName}', 'Storage\StorageController@index');

/*********************************/
/* No GET routes below will work */
/*********************************/
Route::match(['get'], '{all}', 'Home\HomeController@index')->where(['all' => '.*']); // Need regex filter witch data can be passed

