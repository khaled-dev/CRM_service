<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;

class Contact extends Model
{
    use IdConverter;

    protected $collection = 'contracts';

    /**
     * Contact ID: Unique identifier.
     * Name: Full name.
     * Position: Job title at the company.
     * Email: Contact email.
     * Phone: Contact phone number.
     * Account ID: Identifier of the associated account.
     */


    /**
     * account
     */

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
    ];
}
