<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\MorphMany;

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
        'type',
        'outcome',
        'date',
        'note'
    ];

    /**
     * the contacts of this Activity.
     *
     * @return MorphMany
     */
    public function contacts(): MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }
}
