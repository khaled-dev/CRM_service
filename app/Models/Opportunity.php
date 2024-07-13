<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Opportunity extends Model
{
    use IdConverter;

    protected $collection = 'opportunities';

    public const STAGES = [
        'qualification', 'needs analysis', 'proposal', 'negotiation', 'won', 'lost',
    ];

    /**
     * Lead ID: Identifier of the associated lead.
     * Deal Value: Estimated value of the deal.
     * Stage: Stage of the sales process (Qualification, Needs Analysis, Proposal, Negotiation,
     * Won, Lost).
     * Close Date: Expected closing date of the deal.
     * Probability: Probability of closing the deal successfully.
     */
    protected $fillable = [
        'deal_value',
        'stage',
        'close_date',
        'probability',
    ];

    /**
     * the lead of this opportunity.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
