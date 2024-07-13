<?php

namespace App\Http\Controllers;

use App\Http\Service\ResponseBuilder;
use ArrayAccess;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0",
 *     description="A sample API to demonstrate usage of OpenAPI annotations."
 * )
 */
abstract class Controller
{
    /**
     * Uses response builder to generate json response for the given resource.
     */
    protected function generateResponse(
        array|ArrayAccess $data,
        array $metadata = [],
        string $message = 'Request Successful',
        bool $state = true
    ): array {
        return (new ResponseBuilder)
            ->addState($state)
            ->addMessage($message)
            ->addData($data)
            ->addMetadata($metadata)
            ->build();
    }
}
