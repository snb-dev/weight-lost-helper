<?php

return [
    'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
    'default_model' => env('OPENROUTER_DEFAULT_MODEL', 'openrouter/auto'),
    'recommended_free_models' => [
        'openrouter/auto',
        'mistralai/mistral-small-3.1-24b-instruct:free',
        'meta-llama/llama-3.3-8b-instruct:free',
        'google/gemma-3-12b-it:free',
    ],
    'request_timeout' => (int) env('OPENROUTER_REQUEST_TIMEOUT', 60),
];
