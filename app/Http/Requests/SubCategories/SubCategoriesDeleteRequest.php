<?php

namespace App\Http\Requests\SubCategories;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriesDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ($this->user()->isAdmin() || $this->user()->isModerator());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'id' => 'required|numeric|exists:sub_categories,id'
		];
    }
}
