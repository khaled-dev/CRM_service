<?php

namespace App\Http\Resources\Concerns;


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
     * @param array $data
     * @return $this
     */
    public function addData(array $data): ResponseBuilder
    {
        $this->fullResponse['data'] = $data;

        return $this;
    }

    /**
     * Append resource's metadata.
     *
     * @param array $metadata
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
     * @param string $message
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
     * @param bool $state
     * @return $this
     */
    public function addState(bool $state = true): ResponseBuilder
    {
        $this->fullResponse['state'] = $state;

        return $this;
    }

    /**
     * Build the response array
     *
     * @return array
     */
    public function build(): array
    {
        return $this->fullResponse;
    }
}
