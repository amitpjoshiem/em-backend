<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | SystemStatus Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /**
     * List of services to check when checking the system state.
     */
    'services' => [
        'cache'   => false,
        'db'      => false,
        'env'     => false,
        'redis'   => true,
        'session' => false,
        'storage' => false,
    ],

    'cache'   => [
        // TTL in second
        'ttl' => 3,
    ],

    /**
     * A list of ENV, for example 'APP_KEY', to be checked by the Env check.
     */
    'env'     => [
        'required' => [

        ],
    ],

    /**
     * A list of disks, for example 'local', to be checked by the Storage check.
     */
    'storage' => [
        'disks' => [

        ],
    ],
];
