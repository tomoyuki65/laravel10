<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(CreateUserRequest $request)
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

    public function update(UpdateUserRequest $request, string $uid)
    {
        return $this->userService->updateUser($request, $uid);
    }

    public function delete(Request $request, string $uid)
    {
        return $this->userService->destroyUser($request, $uid);
    }
}
