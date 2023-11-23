<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(Request $request)
    {
        return $this->userService->createUser($request);
    }

    public function users(Request $request)
    {
        return $this->userService->getUsers($request);
    }

    public function user(Request $request, string $uid)
    {
        return $this->userService->getUser($request, $uid);
    }

    public function update(Request $request, string $uid)
    {
        return $this->userService->updateUser($request, $uid);
    }

    public function delete(Request $request, string $uid)
    {
        return $this->userService->destroyUser($request, $uid);
    }
}
