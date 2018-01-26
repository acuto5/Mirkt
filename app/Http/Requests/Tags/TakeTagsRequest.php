<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class TakeTagsRequest extends FormRequest
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
            'take' => 'required|numeric|max:1000|min:0',
			'tags_ids' => 'nullable|array',
			'tags_ids.*' => 'nullable|numeric',
			'searchTagInput' => 'nullable|string|max:200'
        ];
    }
}
