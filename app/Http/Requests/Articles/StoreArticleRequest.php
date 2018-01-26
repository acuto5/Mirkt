<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 * @return bool
	 */
	public function authorize()
	{
		return ($this->user()->isAdmin() || $this->user()->isModerator());
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 * @return array
	 */
	public function rules()
	{
		return [
			'title'              => 'required|string|min:5|max:200|unique:articles,title',
			'content'            => 'required|string|min:30|max:10000',
			'sub_category_id'    => 'required|numeric|exists:sub_categories,id',
			'tags_ids'           => 'nullable|array',
			'tags_ids.*'         => 'required_with:tags_ids|integer|exists:tags,id',
			'images'             => 'required|array',
			'images.*'           => 'required_with:images|image|mimes:jpeg,jpg|max:10000', // 10Mb
			'is_default_img_old' => 'required_with:images|boolean',
			'default_image_id'   => 'required_with:images|numeric|min:0',
		];
	}
}
