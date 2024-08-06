<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Pipeline;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Modules\Admin\Http\Responses\AdminLogoutResponse;
use Modules\Admin\Interfaces\AdminLoginResponse;
use Modules\Main\Class\FleshMessages;

class AuthController extends AuthenticatedSessionController
{

    public function loginPage()
    {
        return Inertia::module('Admin::login');
    }

    public function loginPost(LoginRequest $request)
    {

        return parent::loginPipeline($request)->then(function ($request) {
            return app(AdminLoginResponse::class);
        });
    }

    public function logout(Request $request)
    {

        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return app(AdminLogoutResponse::class);
    }

}
