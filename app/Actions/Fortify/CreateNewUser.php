<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // Split provided full name into first/last name and generate a username.
        $parts = explode(' ', $input['name'], 2);
        $fname = $parts[0] ?? $input['name'];
        $lname = $parts[1] ?? '';
        $baseUsername = str_contains($fname, ' ') ? Str::slug($fname) : Str::slug($fname . ($lname ? '.' . $lname : ''));
        $username = $baseUsername;
        $i = 0;
        while (User::where('username', $username)->exists()) {
            $i++;
            $username = $baseUsername . $i;
        }

        return User::create([
            'fname' => $fname,
            'lname' => $lname,
            'username' => $username,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
