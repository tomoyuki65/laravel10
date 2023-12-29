<?php

namespace App\OpenApi\Responses\Common;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;

class CreatedResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()
                        ->properties(
                            Schema::string('message')
                                ->example('OK')
                                ->description('created'),
                        );

        return Response::created()
                   ->description('正常終了')
                   ->content(
                       MediaType::json()
                           ->schema($response)
                   );
    }
}
