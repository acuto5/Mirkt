<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $visible = ['id', 'name', 'subCategories', 'level'];
	
	protected $fillable = ['name'];
	
	public function subCategories()
	{
		return $this->hasMany('App\SubCategory', 'category_id')
			->select('id', 'name', 'level', 'category_id')
			->orderBy('level', 'desc');
	}
}
