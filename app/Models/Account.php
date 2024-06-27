<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\BelongsTo;

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
     *
     * @return BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
