<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\MorphMany;

class Customer extends Model
{
    use IdConverter;

    protected $collection = 'customers';

    public const POTENTIAL = 'potential';
    public const CURRENT = 'current';
    public const STATUS = [self::POTENTIAL, self::CURRENT];

    /**
     * Client ID: Unique identifier for each customer.
     * Client Status: Customer status (Current Client, Potential Client).
     * Name: Customer contact name.
     * Contact Information: Customer contact information (telephone and email).
     * Company Name: Name of the customer's company.
     * Address: Physical address of the company.
     * Country: Country of the customer's location.
     * Type of Client: Type of client (LSP, Customer Service, Technical Support, Sales, etc.).
     * Company Logo: Link to the company's logo.
     * Comments: Notes on the customer.
     * Date of Last Comment: Date of the last comment added.
     * Last Contacted: Date the customer was last contacted.
     * Pending Requests: Pending customer requests.
     */

    /**
     * comments...
     * pending requests..
     */

    protected $fillable = [
        'name',
        'company_name',
        'address',
        'phone',
        'email',
        'country',
        'status',
        'type',
    ];

    /**
     * the comments of this customer.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * the requests of this customer.
     *
     * @return HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
