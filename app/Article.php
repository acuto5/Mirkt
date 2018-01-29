<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Article extends Model
{
	use Searchable;
	
	private $diskName = 'article-images';
	
	protected $visible = [
		'id', 'title', 'content', 'is_draft', 'headerImage', 'sub_category_id', 'subCategory', 'author', 'created_at',
		'tags',
		'images',
	];
	
	protected $fillable = ['title', 'content', 'sub_category_id', 'user_id'];
	
	// Search settings
	public function searchableAs()
	{
		return 'title';
	}
	
	public function storeImages(Request $request, $nameOfImagesArray)
	{
		if ($request->images) {
			$files = $request->file($nameOfImagesArray);
			
			foreach ($files as $key => $image) {
				// Store image
				$path = $image->store('', $this->diskName);
				
				// Generate img full url
				$url = Storage::disk($this->diskName)->url($path);
				
				// check if new image is default
				$isDefault = (!$request->is_default_img_old && (int)$request->default_image_id === $key) ? true : false;
				
				// Make relationship with article
				$this->images()->create(['url' => $url, 'is_default' => $isDefault]);
			}
		}
	}
	
	// Relationships
	public function author()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
	
	public function subCategory()
	{
		return $this->belongsTo('App\SubCategory', 'sub_category_id');
	}
	
	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'tag_article');
	}
	
	public function headerImage()
	{
		return $this->hasOne('App\Image', 'article_id')->where('is_default', true);
	}
	
	public function images()
	{
		return $this->hasMany('App\Image', 'article_id');
	}
	
	public function detachImages()
	{
		if ($this->images) {
			foreach ($this->images as $image) {
				$image->article_id = null;
				$image->save();
			}
		}
	}
}