<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
			'id'   => 'required|numeric|exists:tags,id',
			'name' => [
				'required', 'string', 'min:3', 'max:200', Rule::unique('tags')->ignore($this->id),
			],
		];
	}
}
