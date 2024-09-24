<?php

return [
    // "paths" => ['api/*', '*'],
    // "allowed_methods" => ['*'],
    // "allowed_origin" => ['http://localhost:3000','*'],
    // "allowed_origins_patterns" => [],
    // "allowed_headers" => ["*"],
    // "exposed_headers" => [],
    // "max_age" => 0,
    // "supports_credentials" => false,
    'paths' => ['api/*'],
   'allowed_methods' => ['*'],
   'allowed_origins' => ['https://www.crasherofficialstore.com', 'http://192.168.18.191', 'http://localhost:3000'],
   'allowed_origins_patterns' => [],
   'allowed_headers' => ['*'],
   'exposed_headers' => [],
   'max_age' => 0,
   'supports_credentials' => false,
];
