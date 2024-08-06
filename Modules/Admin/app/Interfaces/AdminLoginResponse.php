<?php

namespace Modules\Admin\Interfaces;
use Illuminate\Contracts\Support\Responsable;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class AdminLoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
    {
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(route('adminWeb.index'));
    }
}
