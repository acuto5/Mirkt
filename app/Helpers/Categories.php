<?php

function getAllCategoriesWithSubCategories(){
    $with = [
        'subCategories' => function($query){
            $query->select('id', 'name', 'category_id')->orderBy('level', 'desc');
        }
    ];
    
	$categories = \App\Category::select('id', 'name')->with($with)->orderBy('level', 'desc')->get();
	
	return json_encode($categories->toArray());
}