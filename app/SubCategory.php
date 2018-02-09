<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
	protected $visible = ['id', 'category_id', 'category', 'name', 'level', 'articles', 'latestSixPublishedArticles'];
	
	protected $fillable = ['category_id', 'name'];
	
	public function category()
	{
		return $this->belongsTo('App\\Category', 'category_id');
	}
	
	public function articles()
	{
		return $this->hasMany('App\Article', 'sub_category_id')->with('headerImage')->latest();
	}
	
	public function latestSixPublishedArticles()
	{
		return $this->hasMany('App\Article', 'sub_category_id')
			->where('is_draft', 0)
			->with('headerImage')
			->latest()
			->take(6);
	}
}
