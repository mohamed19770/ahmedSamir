<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Lock (Coming Soon)
    |--------------------------------------------------------------------------
    |
    | Temporary gate with username/password while the site is under construction.
    | Set SITE_LOCK_ENABLED=false when you are ready to launch publicly.
    |
    */

    'enabled' => env('SITE_LOCK_ENABLED', false),

    'username' => env('SITE_LOCK_USERNAME', ''),

    'password' => env('SITE_LOCK_PASSWORD', ''),

];
