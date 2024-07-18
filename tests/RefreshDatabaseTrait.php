<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

trait RefreshDatabaseTrait
{
    protected function refreshDatabase()
    {
        // Reset MongoDB collections
        $mongo = DB::connection('mongodb_test');
        foreach ($mongo->listCollections() as $collection) {
            $mongo->getCollection($collection->getName())->drop();
        }
    }
}
