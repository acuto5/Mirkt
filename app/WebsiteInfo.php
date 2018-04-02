<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteInfo extends Model
{
    /**
     * Table name in database
     * @var string
     */
    protected $table = 'website_info';
    
    /**
     * Field in database will be available for mass assignment.
     * @var array
     */
    protected $fillable = ['content'];
    
    /**
     * The attributes that should be visible in arrays.
     * @var array
     */
    protected $visible = ['content'];
    
    /**
     * Clean content from html tags.
     *
     * @param $content
     */
    public function setContentAttribute(string $content): void
	{
		$this->attributes['content'] = clean($content);
	}
}
