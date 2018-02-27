<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
			'email'        => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
			'is_admin'     => 'nullable|boolean',
			'is_moderator' => 'nullable|boolean',
			'password'     => 'required|min:8|max:255',
			'new_password' => 'nullable|string|min:8|confirmed'
        ];
    }
}
