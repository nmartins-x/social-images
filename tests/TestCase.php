<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    function authUser() {
        $user = User::factory()->create();
        return $this->actingAs($user);
    }
}
