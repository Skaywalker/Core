<?php

/**
 * Get the language of the application
 * @return string
 *
 * **/

use Illuminate\Support\Facades\Session;

if (!function_exists('lang')){
    function lang()
    {
        return Session::get('lang');
    }
}