<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /**
     * Field in database will be available for mass assignment.
     * @var array
     */
    protected $fillable = ['url', 'is_default', 'article_id'];
    
    /**
     * The attributes that should be visible in arrays.
     * @var array
     */
    protected $visible = ['id', 'url', 'is_default'];
    
    /**
     * Relationship with article
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article(): BelongsTo
	{
		return $this->belongsTo(Article::class, 'article_id');
	}
    
    /**
     * Make image default
     *
     * @param int $imageID
     */
    public static function makeImageDefault(int $imageID): void
    {
        $image = self::find($imageID);
		
		$image->update(['is_default' => true]);
	}
}
