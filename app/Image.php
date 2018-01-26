<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $fillable = ['url', 'is_default'];
	protected $visible  = ['id', 'url', 'is_default'];
	
	public function user()
	{
		return $this->belongsTo('App/User', 'user_id');
	}
	
	public function article()
	{
		return $this->belongsTo(Article::class, 'article_id');
	}
}
