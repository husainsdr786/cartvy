<?php

return [
    /*'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],*/
    
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
    ],

    'guards' => [
        'api' => [
            'driver' => 'passport',
            'provider' => 'users'
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class
        ]
    ],

    'passwords' => [
        //
    ],
];
