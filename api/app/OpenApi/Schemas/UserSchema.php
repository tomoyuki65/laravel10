<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class UserSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('User')
            ->properties(
                Schema::integer('id')
                    ->example('1')
                    ->description('usersのid'),
                Schema::string('uid')
                    ->example('azby0tie9k')
                    ->description('Firebaseのuid'),
                Schema::string('name')
                    ->example('オープンAPIユーザー')
                    ->description('名前'),
                Schema::string('email')
                    ->example('openapi@example.com')
                    ->description('メールアドレス'),
                Schema::string('created_at')
                    ->format('date-time')
                    ->example('2023-12-26 23:51:57')
                    ->description('作成日時'),
                Schema::string('updated_at')
                    ->format('date-time')
                    ->example('2023-12-26 23:51:57')
                    ->description('更新日時'),
                Schema::string('deleted_at')
                    ->format('date-time')
                    ->example('2023-12-26 23:51:57')
                    ->description('削除日時'),
            );
    }
}
