<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'source' => $this->source,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'interest_level' => $this->interest_level,
            'assigned_to' => new UserResource(assignedTo),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
