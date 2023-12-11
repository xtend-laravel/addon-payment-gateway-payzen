<?php

return [
    'mode' => env('PAYZEN_MODE', 'test'),
    'username' => env('PAYZEN_USERNAME', 'test'),
    'test_password' => env('PAYZEN_TEST_PASSWORD', '1234567890'),
    'production_password' => env('PAYZEN_PRODUCTION_PASSWORD', '1234567890'),
];
