<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Register a new user
    // public function register(RegisterRequest $request)
    // {
    //     $data = $request->validated();
    //     $response = $this->authService->register($data);

    //     return response()->json($response, 201);
    // }

    // Log in an existing user
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $response = $this->authService->login($data);
    
        // Check if the response contains an error and handle it accordingly
        if (isset($response['error']) && $response['error'] === true) {
            return response()->json(['message' => $response['message']], 401);
        }
    
        // If login was successful, return the response with a 200 status
        return response()->json($response, 200);
    }
    
}
