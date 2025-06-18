<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => ['required', 'same:new_password'],
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'old_password.required' => 'The old password is required.',
            'new_password.required' => 'The new password is required.',
            'new_password.min' => 'The new password must be at least 8 characters long.',
            'confirm_password.required' => 'The confirm password field is required.',
            'confirm_password.same' => 'The new password and confirm password do not match.',
        ];

        return $messages;
    }
}
