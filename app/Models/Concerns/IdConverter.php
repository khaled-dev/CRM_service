<?php

namespace App\Models\Concerns;

use MongoDB\BSON\ObjectId;

trait IdConverter
{
    /**
     * Override laravel getId magic method.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id instanceof ObjectId ? (string) $this->id : $this->id;
    }
}
