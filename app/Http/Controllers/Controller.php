<?php

namespace App\Http\Controllers;

use ArrayAccess;
use OpenApi\Annotations as OA;
use App\Http\Service\ResponseBuilder;

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
     *
     * @param array|ArrayAccess $data
     * @param array $metadata
     * @param string $message
     * @param bool $state
     * @return array
     */
    protected function generateResponse(
        array|ArrayAccess $data,
        array $metadata = [],
        string $message = 'Request Successful',
        bool $state = true
    ) : array {
        return (new ResponseBuilder)
            ->addState($state)
            ->addMessage($message)
            ->addData($data)
            ->addMetadata($metadata)
            ->build();
    }
}
