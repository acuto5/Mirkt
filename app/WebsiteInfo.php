<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteInfo extends Model
{
    protected $table = 'website_info';
	protected $fillable = ['content'];
	protected $visible = ['content'];
	
	public function setContentAttribute($content)
	{
		$this->attributes['content'] = clean($content);
	}
}
