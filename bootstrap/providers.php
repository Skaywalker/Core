<?php

return [
    App\Providers\AppServiceProvider::class,
    \Modules\User\app\Providers\FortifyServiceProvider::class,
    \Modules\Main\FortifyServiceProvider::class,
];
