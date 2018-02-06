<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class GetAllDraftArticlesRequest extends FormRequest
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
			'order_by' => 'nullable|string|min:6|max:6',
			'page' => 'nullable|numeric'
		];
	}
}
