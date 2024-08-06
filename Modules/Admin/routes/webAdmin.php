<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\RoutePath;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$limiter=config('fortify.limiters.login');

Route::middleware(['auth',])->group(function (){
    Route::get('/',[AdminController::class,'index'])->name('index');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

});
Route::get('/login',[AuthController::class,'loginPage'])->name('login');

Route::post('/login',[AuthController::class, 'loginPost'])->middleware(array_filter([
    'guest:'.config('fortify.guard'),
    $limiter ? 'throttle:'.$limiter : null,
]))->name('login-post');

