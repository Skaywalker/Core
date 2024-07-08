<?php

namespace Modules\Website\tests\Feature;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Modules\Main\View\Components\Trans;
use Tests\TestCase;

class TransComponentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Mock the Redis facade
        Redis::shouldReceive('get')->andReturnUsing(function ($key) {
            if ($key == "translations.en") {
                return json_encode(['welcome' => 'Welcome']);
            }
            return null;
        });

        Redis::shouldReceive('set')->andReturn(true);
        Redis::shouldReceive('expire')->andReturn(true);

        // Mock the session facade
        Session::shouldReceive('get')->andReturn('en');

    }

    public function testTransComponentWithRedisData()
    {
        // Render the component
        $view = (new Trans())->render();
        $this->assertStringContainsString('Welcome', $view);
    }

}
