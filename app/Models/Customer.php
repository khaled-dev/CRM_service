<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;

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
     * contracts..
     * pending requests..
     */

    protected $fillable = [
        'name',
        'email',
        'telephone',
        'company_name',
        'address',
        'country',
        'status',
        'type',
    ];

}
