<?php

namespace App\Http\Requests\tags;

use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
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
			'tag'  => 'nullable|string|min:2|max:200',
			'page' => 'nullable|numeric',
		];
	}
}
