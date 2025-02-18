<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

class Account extends Model
{
    use IdConverter;

    protected $collection = 'accounts';

    public const ACTIVE = 'active';

    public const INACTIVE = 'inactive';

    public const STATUS = [self::INACTIVE, self::ACTIVE];

    /**
     * Account ID: Unique identifier.
     * Account Name: Name of the company.
     * Industry: Sector in which the company operates.
     * Annual Revenue: Company's annual revenue.
     * Assigned To: Person assigned (salesperson or account manager).
     * Account Status: Account status (Active, Inactive)
     */

    /**
     * Assigned To (salesperson or account manager)
     */
    protected $fillable = [
        'name',
        'industry',
        'annual_revenue',
        'status',
    ];

    /**
     * the User assigned to this account.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * the contacts of this account.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
