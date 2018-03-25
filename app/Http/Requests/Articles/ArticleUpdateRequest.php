<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleUpdateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 * @return array
	 */
	public function rules()
	{
		return [
			'id'                 => 'required|numeric|exists:articles,id',
			'sub_category_id'    => 'required|numeric|exists:sub_categories,id',
			'content'            => 'required|string|min:30|max:10000',
			'tags_ids'           => 'nullable|array',
			'tags_ids.*'         => 'required_with:tags_ids|integer|exists:tags,id',
			'images'             => 'required_without:old_images_ids|array',
			'images.*'           => 'required_with:images|image|mimes:jpeg,jpg|max:10000', // 10Mb
			'old_images_ids'     => 'nullable|array',
			'old_images_ids.*'   => 'required_with:old_images_ids|integer|exists:images,id',
			'title'              => [
				'required', 'string', 'min:5', 'max:200', Rule::unique('articles')->ignore($this->id),
			],
			'is_default_img_old' => 'required_with:images,old_images_ids|boolean',
			'default_image_id'   => 'required_with:images,old_images_ids|numeric|min:0',
		];
	}
}
