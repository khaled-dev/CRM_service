<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\MorphMany;

class Lead extends Model
{
    use IdConverter;

    protected $collection = 'leads';


    /**
     * Source: Source of the lead (website, referral, event).
     * Lead Status: Status of the lead (New, Contacted, Qualified, Lost).
     * Assigned To: Person assigned (responsible salesperson).
     * Contact Information: Contact information (email, phone number).
     * Interest Level: Level of interest (High, Medium, Low).
     * Comments: Notes on the lead.
     */

    /**
     * Comments
     * Contact
     * Assigned To
     */

    protected $fillable = [
        'source',
        'status',
        'interest_level',
    ];


    /**
     * the User assigned to this lead.
     *
     * @return BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * the contacts of this Lead.
     *
     * @return MorphMany
     */
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * the comments of this lead.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
