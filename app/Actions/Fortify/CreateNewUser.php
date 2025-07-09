<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
	use PasswordValidationRules;

	/**
	 * Validate and create a newly registered user.
	 *
	 * @param  array  $input
	 * @return \App\Models\User
	 */
	public function create(array $input)
	{
		Validator::make($input, [
			'emp_code' => ['required', 'string', 'max:255'],
			'user_role_id' => ['required', 'integer'],           
			'username' => ['required', 'string', 'max:255', 'unique:users'],
			// 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => $this->passwordRules(),
			'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
		])->validate();

		return User::create([
			'emp_code' => $input['emp_code'],
			'user_role_id' => $input['user_role_id'],
			'username' => $input['username'],
			// 'email' => $input['email'],
			'password' => Hash::make($input['username']),
		]);
	}
}
