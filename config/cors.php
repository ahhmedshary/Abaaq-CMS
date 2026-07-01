<?php

// Drop this file into config/cors.php in your fresh Laravel install,
// replacing the default one. It allows your Next.js frontend domain
// to read from /api/* while keeping the admin panel session-based.

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['GET'],

    // Replace with your real Next.js frontend domain(s) before going live.
    // Wildcards are not recommended for production.
    'allowed_origins' => [
        'http://localhost:3000',
        'https://your-frontend-domain.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
