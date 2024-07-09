<?php

namespace App\Http\Resources;

use App\Http\Resources\Concerns\ResponseBuilder;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{

    /**
     * Uses response builder to generate json response for the given resource.
     *
     * @param array $data
     * @param array $metadata
     * @param string $message
     * @param bool $state
     * @return array
     */
    protected function generateResponse(array $data, array $metadata = [], string $message = 'Request Successful', bool $state = true): array
    {
        return (new ResponseBuilder)
            ->addState($state)
            ->addMessage($message)
            ->addData($data)
            ->addMetadata($metadata)
            ->build();
    }
}
