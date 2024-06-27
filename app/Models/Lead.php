<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;

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
}
