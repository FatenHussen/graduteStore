<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Register a new user
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->generateTokenResponse($user);
    }

    // Log in a user
    public function login(array $data)
    {
        // Attempt to authenticate the user with email and password
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
    
            // Ensure $user is not null before calling generateTokenResponse
            if ($user instanceof User) {
                return $this->generateTokenResponse($user);
            }
        }
    
        // If authentication fails, return an array structure instead of a JsonResponse
        return [
            'error' => true,
            'message' => 'Invalid credentials',
        ];
    }
    
    

    // Generate token response
    private function generateTokenResponse(User $user)
    {
        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
