<?php

namespace Modules\Admin\Http\Middleware;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Reflector;
use Illuminate\Support\Str;
use Inertia\Middleware;
use Modules\Admin\Class\AdminRouter;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Tighten\Ziggy\Ziggy;

class HandleAdminInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'adminApp';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        return [...parent::share($request),
            'Ziggy' => fn() => [
                ...(new AdminRouter)->toArray(), [
                    'location' => $request->url(),
                ],
            ],
            'flash' => fn() => collect(session()->get('_flash')['new']??[])
                ->mapWithKeys(fn($value) => [$value => session()->get($value)])
                ->toArray()];
    }
}
