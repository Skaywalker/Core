<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Modules\Main\Class\FleshMessages;

class AuthController extends Controller
{

    public function loginPage():InertiaResponse
    {
        \Log::channel('dev')->info('Login Page',['app'=>app()->getLocale(),'lang'=>lang()]);

        FleshMessages::alertMessage(trans('admin::alerts.error',),trans('admin::alerts.message',),'success',true);

     return Inertia::module('Admin::login');
    }
    public function loginPost(Request $request):RedirectResponse
    {
        dd($request->all());
        return redirect()->route('admin.dashboard');
    }


}
