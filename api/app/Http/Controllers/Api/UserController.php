<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

// OpenAPI用
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\RequestBodies\User\CreateUserRequestBody;
use App\OpenApi\Responses\Common\CreatedResponse;
use App\OpenApi\Responses\User\UserResponse;
use App\OpenApi\Responses\Common\InternalServerErrorResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;

#[OpenApi\PathItem]
class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * ユーザー作成
     *
     * @param CreateUserRequest $request
     * @return CreatedResponse
     */
    #[OpenApi\Operation(tags: ['user'])]
    #[OpenApi\RequestBody(factory: CreateUserRequestBody::class)]
    #[OpenApi\Response(factory: CreatedResponse::class)]
    #[OpenApi\Response(factory: InternalServerErrorResponse::class)]
    public function create(CreateUserRequest $request)
    {
        return $this->userService->createUser($request);
    }

    public function users(Request $request)
    {
        return $this->userService->getUsers($request);
    }

    /**
     * ユーザー情報取得
     *
     * @param Request $request
     * @param string $uid
     * @return CreatedResponse
     */
    #[OpenApi\Operation(tags: ['user'], security: BearerTokenSecurityScheme::class)]
    #[OpenApi\Response(factory: UserResponse::class)]
    #[OpenApi\Response(factory: InternalServerErrorResponse::class)]
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
