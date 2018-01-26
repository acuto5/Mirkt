<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
	use Searchable;
	
	protected $visible   = ['id', 'name'];
	protected $fillable = ['name'];
	
	// Search settings
	public function searchableAs()
	{
		return 'name';
	}
	
	public function articles()
	{
		return $this->belongsToMany('App\Article', 'tag_article');
	}
}
