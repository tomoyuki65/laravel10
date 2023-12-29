<?php

namespace App\OpenApi\Responses\User;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use App\OpenApi\Schemas\UserSchema;

class UserResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
                   ->description('ユーザー情報取得に成功')
                   ->content(
                       MediaType::json()
                           ->schema(UserSchema::ref())
                   );
    }
}
