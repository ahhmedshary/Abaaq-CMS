<?php

return [
    'currency_label' => env('STORE_CURRENCY_LABEL', 'ر.س'),
    'currency_code' => env('STORE_CURRENCY_CODE', 'SAR'), // ISO code, used for Stripe
    'flat_shipping_fee' => (int) env('STORE_SHIPPING_FEE', 25),
];
