<?php

namespace App\Http\Requests\SubCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoriesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'category_id' => 'required|numeric|min:0|max:200|exists:categories,id',
			'name'        => [
				'required', 'string', 'min:3', 'max:15', Rule::unique('sub_categories')->where(function ($query) {
					$query->where('category_id', $this->category_id);
				}),
			],
        ];
    }
}
