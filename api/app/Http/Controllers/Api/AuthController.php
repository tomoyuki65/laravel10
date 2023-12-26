<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\Auth\SignupRequest;

class AuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signup(SignupRequest $request)
    {
        return $this->authService->registerUser($request);
    }
}