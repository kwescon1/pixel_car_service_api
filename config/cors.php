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

    'paths' => ['api/*'],  // Apply CORS only to API routes

    'allowed_methods' => ['*'],  // Allow all HTTP methods

    'allowed_origins' => ['https://' . getHostByName(getHostName())],  // Allow requests from API server IP

    'allowed_origins_patterns' => [],  // No dynamic origin patterns

    'allowed_headers' => ['Authorization', 'Content-Type', 'X-Requested-With', 'Accept', 'Origin'],  // Essential headers

    'exposed_headers' => [],  // No headers exposed to the client

    'max_age' => 3600,  // Cache preflight requests for 1 hour

    'supports_credentials' => false,  // No credentials (cookies) are supported in stateless API

];
