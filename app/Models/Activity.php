<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Activity extends Model
{
    use IdConverter;

    protected $collection = 'activities';

    /**
     * Type: Type of activity (Call, Email, Meeting, Demonstration).
     * Date: Date of the activity.
     * Outcome: Outcome of the activity.
     * Notes: Detailed notes on the interaction.
     * Contact ID: Identifier of the associated contact.
     */
    protected $fillable = [
        'contact_id',
        'type',
        'outcome',
        'date',
        'note',
    ];

    public const TYPE_CALL = 'call';

    public const TYPE_EMAIL = 'email';

    public const TYPE_MEETING = 'meeting';

    public const TYPE_DEMONSTRATION = 'demonstration';

    public const TYPES = [self::TYPE_CALL, self::TYPE_EMAIL, self::TYPE_MEETING, self::TYPE_DEMONSTRATION];

    /**
     * the contact of this Activity.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', '_id');
    }
}
