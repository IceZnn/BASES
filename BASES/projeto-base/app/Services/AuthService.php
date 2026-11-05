<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function login(array $credentials, bool $remember = false): bool
    {
        // Auth::attempt delegates password verification to Laravel's configured hasher.
        if (! Auth::attempt($credentials, $remember)) {
            return false;
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();

            return false;
        }

        return true;
    }

    public function authenticateOrFail(array $credentials): User
    {
        if (! $this->login($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'As credenciais informadas são inválidas.',
            ]);
        }

        return Auth::user();
    }
}
