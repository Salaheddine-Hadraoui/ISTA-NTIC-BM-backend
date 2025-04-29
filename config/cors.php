<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

   'supports_credentials' => true,
    'allowed_origins' => [env('FRONTEND_URL')],  
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'exposed_headers' => [],
    'max_age' => 0,
    'hosts' => [],
    'paths' => ['api/*','course-pdf/*'],  

];
