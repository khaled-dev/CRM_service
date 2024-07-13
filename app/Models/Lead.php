<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\MorphMany;

class Lead extends Model
{
    use IdConverter;

    protected $collection = 'leads';

    public const STATUS_NEW = 'new';

    public const STATUS_CONTRACTED = 'contacted';

    public const STATUS_QUALIFIED = 'qualified';

    public const STATUS_LOST = 'lost';

    public const STATUS = [self::STATUS_NEW, self::STATUS_CONTRACTED, self::STATUS_QUALIFIED, self::STATUS_LOST];

    public const SOURCE_WEBSITE = 'website';

    public const SOURCE_REFERRAL = 'referral';

    public const SOURCE_EVENT = 'event';

    public const SOURCES = [self::SOURCE_WEBSITE, self::SOURCE_REFERRAL, self::SOURCE_EVENT];

    public const INTEREST_HIGH = 'high';

    public const INTEREST_MEDIUM = 'medium';

    public const INTEREST_LOW = 'low';

    public const INTERESTS = [self::INTEREST_HIGH, self::INTEREST_MEDIUM, self::INTEREST_LOW];

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
     * Assigned To
     */
    protected $fillable = [
        'source',
        'status',
        'phone',
        'email',
        'interest_level',
    ];

    /**
     * the User assigned to this lead.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', '_id');
    }

    /**
     * the comments of this lead.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
