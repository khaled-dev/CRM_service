<?php

namespace App\Http\Service;

use ArrayAccess;

class ResponseBuilder
{
    /**
     * Holds the full data of the response.
     *
     * @var array
     */
    private $fullResponse = [];

    /**
     * Append resource's data.
     *
     * @return $this
     */
    public function addData(array|ArrayAccess $data): ResponseBuilder
    {
        $this->fullResponse['data'] = $data;

        return $this;
    }

    /**
     * Append resource's metadata.
     *
     * @return $this
     */
    public function addMetadata(array $metadata = []): ResponseBuilder
    {
        $this->fullResponse['metadata'] = $metadata;

        return $this;
    }

    /**
     * Append resource's message.
     *
     * @return $this
     */
    public function addMessage(string $message = 'Request Successful'): ResponseBuilder
    {
        $this->fullResponse['message'] = $message;

        return $this;
    }

    /**
     * Append resource's state.
     *
     * @return $this
     */
    public function addState(bool $state = true): ResponseBuilder
    {
        $this->fullResponse['state'] = $state;

        return $this;
    }

    /**
     * Build the response array
     */
    public function build(): array
    {
        return $this->fullResponse;
    }
}
