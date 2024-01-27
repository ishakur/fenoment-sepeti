<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
}
