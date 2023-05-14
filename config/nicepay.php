<?php

return [
    'merchant_id' => env('NICEPAY_MERCHANT_ID'),
    'merchant_key' => env('NICEPAY_MERCHANT_KEY'),
    'is_production' => env('NICEPAY_ENVIRONMENT', 'development') === 'production',
    'callback_url' => env('NICEPAY_CALLBACK_URL'),
    'notification_url' => env('NICEPAY_NOTIFICATION_URL')
];
