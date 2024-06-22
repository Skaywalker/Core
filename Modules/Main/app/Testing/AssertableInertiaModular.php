<?php

namespace Modules\Main\Testing;

use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\AssertionFailedError;
use Illuminate\Testing\Fluent\AssertableJson;
use InvalidArgumentException;



class AssertableInertiaModular  extends AssertableJson
{

    private string $component;

    /** @var string */
    private string $url;

    /** @var string|null */
    private  string|null $version;


    public function component(string $value = null, $shouldExist = null): self{

        $parts = explode('::', $value);
        if (count($parts) > 1) {
            // A modul neve
            $module = $parts[0];
            // A komponens neve
            $value = $module.'::'.config('modules.paths.source').'/'.$parts[1];
            $page=$parts[1];

        }

        PHPUnit::assertSame($value, $this->component, 'Unexpected Inertia page component.');
        if ($shouldExist || (is_null($shouldExist) && config('inertia.testing.ensure_pages_exist', true))) {

            try {
                if (isset($module)) {
                    // Ha van modul, akkor a modul nevével és a komponens névvel dolgozunk
                    $path=explode('::', $value);
                    app('inertia.testing.module-view-finder',['moduleName'=>$path[0]])->find($page);
                } else {
                    // Ha nincs modul, akkor csak a komponens névvel dolgozunk
                    app('inertia.testing.view-finder')->find($value);
                }
            } catch (InvalidArgumentException $exception) {
                PHPUnit::fail(sprintf('Inertia page component file [%s] does not exist.', $value));
            }
        }
        return $this;
    }
    public static function fromTestResponse(TestResponse $response): self
    {
        try {

            $response->assertViewHas('page');
            $page = json_decode(json_encode($response->viewData('page')), true);
            PHPUnit::assertIsArray($page);
            PHPUnit::assertArrayHasKey('component', $page);
            PHPUnit::assertArrayHasKey('props', $page);
            PHPUnit::assertArrayHasKey('url', $page);
            PHPUnit::assertArrayHasKey('version', $page);
        } catch (AssertionFailedError $e) {
            PHPUnit::fail('Not a valid Inertia response.');
        }

        $instance = static::fromArray($page['props']);
        $instance->component = $page['component'];

        $instance->url = $page['url'];
        $instance->version = $page['version'];

        return $instance;
    }
    public function url(string $value): self
    {
        PHPUnit::assertSame($value, $this->url, 'Unexpected Inertia page url.');

        return $this;
    }

    public function version(string $value): self
    {
        PHPUnit::assertSame($value, $this->version, 'Unexpected Inertia asset version.');

        return $this;
    }
    public function toArray(): array
    {
        return [
            'component' => $this->component,
            'props' => $this->prop(),
            'url' => $this->url,
            'version' => $this->version,
        ];
    }
}