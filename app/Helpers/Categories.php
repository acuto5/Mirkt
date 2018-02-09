<?php

function getAllCategoriesWithSubCategories(){
	$categories = \App\Category::select('id', 'name')->with('subCategories:id,name,category_id')->orderBy('level', 'desc')->get();
	
	return json_encode($categories->toArray());
}