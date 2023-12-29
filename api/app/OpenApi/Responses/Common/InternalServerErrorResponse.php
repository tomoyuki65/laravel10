<?php

namespace App\OpenApi\Responses\Common;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;

class InternalServerErrorResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()
                        ->properties(
                            Schema::string('message')
                                ->example('Internal Server Error')
                                ->description('internal server error'),
                        );

        return Response::internalservererror()
                   ->description('サーバーエラー')
                   ->content(
                       MediaType::json()
                           ->schema($response)
                   );
    }
}
