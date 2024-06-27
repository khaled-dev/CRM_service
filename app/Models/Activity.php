<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;

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


    /**
     * Contact
     */

    protected $fillable = [
        'type',
        'outcome',
        'date',
        'note'
    ];

}
