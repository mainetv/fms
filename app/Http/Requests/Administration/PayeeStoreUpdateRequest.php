<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;

class PayeeStoreUpdateRequest extends FormRequest
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
      $excludedActions = ['view', 'verify'];
      
      if (in_array($this->input('action'), $excludedActions)) {
         return []; // Skip validation for these actions
      }

      $rules = [
         'payee_type_id' => 'required',
         'tin' => 'required',
         'bank_id' => 'required',
         'bank_account_name' => 'required',
         'bank_account_no' => 'required',
      ];

      if ($this->payee_type_id == 1) {
         $rules += [
            'first_name' => 'required',
            'last_name' => 'required',
         ];
      } elseif ($this->payee_type_id == 2) {
         $rules += [
            'organization_name' => 'required',
         ];
      }

      return $rules;
   }
  
  

   public function messages()
   {
      $messages = [
         'payee_type_id.required' => 'Please select payee type.',
         'tin.required' => 'Please provide tin.',
         'bank_id.required' => 'Please select bank.',
         'bank_account_name.required' => 'Please provide bank account name.',
         'bank_account_no.required' => 'Please provide bank account number.',
      ];
   
      if ($this->payee_type_id == 1) {
            return array_merge($messages, [
               'first_name.required' => 'Please provide first name.',
               'last_name.required' => 'Please provide last name.',
            ]);
      }
   
      if ($this->payee_type_id == 2) {
            return array_merge($messages, [
               'organization_name.required' => 'Please provide organization name.',
            ]);
      }

      return $messages;
   }
      
}
