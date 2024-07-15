<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpportunityResource extends JsonResource
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
            'deal_value' => $this->deal_value,
            'stage' => $this->stage,
            'close_date' => $this->close_date,
            'probability' => $this->probability,
            'lead' => new LeadResource($this->lead),
        ];
    }
}
