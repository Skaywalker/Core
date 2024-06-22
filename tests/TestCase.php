<?php

namespace Tests;

use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Modules\Main\Testing\AssertableInertiaModular;

abstract class TestCase extends BaseTestCase
{
    protected function setUp():void
    {
        parent::setUp();
        $this->withoutVite();
    }
}
