<?php

namespace Modules\Admin\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Fortify;

class AdminLogoutResponse implements \Laravel\Fortify\Contracts\LogoutResponse
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect(route('adminWeb.login'));
    }
}