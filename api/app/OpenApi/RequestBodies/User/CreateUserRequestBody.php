<?php

namespace App\OpenApi\RequestBodies\User;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;

class CreateUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        $response = Schema::object()
                        ->properties(
                            Schema::string('uid')
                                ->example('azby0tie9k')
                                ->description('Firebaseのuid'),
                            Schema::string('name')
                                ->example('オープンAPIユーザー')
                                ->description('名前'),
                            Schema::string('email')
                                ->example('openapi@example.com')
                                ->description('メールアドレス'),
                        )
                        ->required(
                            'uid',
                            'name',
                            'email',
                        );

        return RequestBody::create()
                   ->description('登録ユーザー情報')
                   ->content(
                       MediaType::json()
                           ->schema($response)
                   );
    }
}
