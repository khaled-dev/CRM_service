<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'industry' => $this->industry,
            'annual_revenue' => $this->annual_revenue,
            'status' => $this->status,
            'assigned_to' => new UserResource($this->assignedTo),
            'contacts' => ContactResource::collection($this->contacts),
        ];
    }
}
