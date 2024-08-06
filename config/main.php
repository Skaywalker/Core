<?php

use Modules\Main\Http\Middleware\AuthenticateSession;

return[
    /*-----------------------
 * Autentication session
 *------------------------
 *  */
    'auth'=>AuthenticateSession::class,
//    'guest'=>Modules\Main\Http\Middleware\RedirectIfAuthenticated::class,

];