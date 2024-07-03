<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\MorphTo;

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

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
    ];


    /**
     * the account of this contact.
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * the activities of this contact.
     *
     * @return HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

}
