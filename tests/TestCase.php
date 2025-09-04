<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    function authUser(?User $user = null) {
        return $this->actingAs(
            is_null($user) ? User::factory()->create() : $user
        );
    }
}
