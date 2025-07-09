<?php

namespace App\Http\Requests\Administration;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'users_employee_code' => 'required|string',
            'users_user_role_id' => 'required|array',
            // 'users_user_role_id.*' => 'exists:user_roles,id',
        ];
    }

    public function messages()
    {
        return [
            'users_employee_code.required' => 'The employee field is required',
            'users_user_role_id.required' => 'The user role field is required',
        ];
    }
}
