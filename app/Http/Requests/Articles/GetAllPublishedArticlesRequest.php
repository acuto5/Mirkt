<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class GetAllPublishedArticlesRequest extends FormRequest
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
			'order_by'        => 'nullable|string|min:6|max:6',
			'sub_category_id' => 'nullable|numeric|exists:sub_categories,id',
			'page'            => 'nullable|numeric',
		];
	}
}
