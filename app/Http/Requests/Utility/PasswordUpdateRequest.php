<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateRequest extends FormRequest
{
   public function authorize(): bool
   {
      return true;
   }

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
         'confirm_password.required' => 'The confirm password field is required.',
         'confirm_password.same' => 'The new password and confirm password do not match.',
      ];

      return $messages;
   }

   public function withValidator($validator)
   {
      $validator->after(function ($validator) {
         $user = Auth::user();
         if (!$user) {
            $validator->errors()->add('old_password', 'User not authenticated.');
            return;
         }

         if (!Hash::check($this->old_password, $user->password)) {
            $validator->errors()->add('old_password', 'The old password is incorrect.');
         }
      });
   }
}
