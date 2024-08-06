<?php

namespace Modules\User\Providers;


use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\FailedPasswordConfirmationResponse as FailedPasswordConfirmationResponseContract;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Http\Responses\LoginResponse;
use Modules\Admin\Interfaces\AdminLoginResponse;
use Modules\User\Actions\Fortify\CreateNewUser;
use Modules\User\Actions\Fortify\ResetUserPassword;
use Modules\User\Actions\Fortify\UpdateUserPassword;
use Modules\User\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Modules\User\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        $this->app->instance(LoginResponse::class, new class extends LoginResponse {
//            public function toResponse($request)
//            {
//                return redirect('/');
//            }
//        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        $this->registerResponseBindings();
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        Fortify::loginView(fn()=>Inertia::module('Admin::login'));
    }
    protected function registerResponseBindings(): void
    {

    }
}
