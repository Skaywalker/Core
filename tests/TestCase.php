<?php

namespace Tests;

use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Testing\TestResponse;
use Modules\Main\Testing\AssertableInertiaModular;

abstract class TestCase extends BaseTestCase
{
    protected function setUp():void
    {
        parent::setUp();
        $this->withoutVite();
        Redis::shouldReceive('get')
            ->andReturnUsing(function ($key) {
                // Itt adja meg az előre definiált Redis válaszokat a kulcs alapján
                $responses = [
                    'translations.en' => json_encode(['welcome' => 'Welcome']), 'translations.hu' => json_encode(['welcome' => 'Üdvőzőljűk']),
                    // További kulcsok és válaszok definiálása
                ];

                return $responses[$key] ?? null;
            });

    }
}
