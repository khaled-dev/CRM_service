<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\BelongsTo;

class Opportunity extends Model
{
    use IdConverter;

    protected $collection = 'opportunities';

    public const STAGE = [
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
     *
     * @return BelongsTo
     */
    public function leads(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
