<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\WebsiteController;

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

Route::group([], function () {
    Route::resource('website', WebsiteController::class)->names('website');
});
Route::get('/lang/{locale?}',function ($locale){
    if (!in_array($locale,config('app.available_languages'))){
        session()->forget('lang');
        return redirect()->back();
    }
    app()->setLocale($locale);
    session()->put('lang',$locale);
    return redirect()->back();
})->name('locale');

Route::get('/', [WebsiteController::class,'index'])->name('website-some-page');