<?php

return [

    'rate_limiter_active' => env('RATE_LIMITER_ACTIVE', true),
    'rate_limiter_engine' => env('RATE_LIMITER_ENGINE', 'provider'),
    'rate_limiter_attempts_per_hour' => env('RATE_LIMITER_ATTEMPTS_PER_HOUR', 1151250),

];
