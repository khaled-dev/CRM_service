<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\IdConverter;
use MongoDB\Laravel\Relations\MorphTo;

class Comment extends Model
{
    use IdConverter;

    protected $collection = 'comments';

    protected $fillable = [
        'comment',
    ];

    /**
     * Get the model that the comment belongs to.
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'commentable_type', 'commentable_id');
    }
}
