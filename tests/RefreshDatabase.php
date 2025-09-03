<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase as BaseRefreshDatabase;

trait RefreshDatabase
{
    use BaseRefreshDatabase {
        BaseRefreshDatabase::beginDatabaseTransaction as parentBeginDatabaseTransaction;
    }
    
    // override function as MongoDb doesn't support transactions
    public function beginDatabaseTransaction()
    {
        return;
    }
}