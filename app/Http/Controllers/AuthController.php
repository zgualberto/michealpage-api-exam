<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    /**
     * Continue registration of user.
     *
     * @param App\Http\Requests\RegisterUserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->userService->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return $this->handleResponse([
            'token' => $token
        ], 201);
    }

    /**
     * Login user.
     *
     * @param App\Http\Requests\LoginUserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = $this->userService->find([
            'email' => $request->input('email')
        ]);

        if (!$user) {
            return $this->handleResponse([
                'message' => "Cannot find that user"
            ], 401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return $this->handleResponse([
                'message' => 'Incorrect password'
            ], 403);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return $this->handleResponse([
            'token' => $token
        ]);
    }

    /**
     * Logout user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->handleResponse([
            'message' => 'Logged out'
        ]);
    }
}
