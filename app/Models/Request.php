<?php

namespace App\Models;

use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Eloquent\Model;

class Request extends Model
{
    use IdConverter;

    protected $collection = 'requests';

    protected $fillable = [
        'request',
    ];
}
