<?php

function getAllCategories(){
	$categories = \App\Category::select('id', 'name')->orderBy('level', 'desc')->get();
	
	return json_encode($categories->toArray());
}