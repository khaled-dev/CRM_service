<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AccountResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->generateResponse(
            parent::toArray($request)
        );
    }
}
