<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section Yodlee Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'api_url'               => env('YODLEE_API_URL'),
    'admin_login'           => env('YODLEE_ADMIN_LOGIN'),
    'client_id'             => env('YODLEE_CLIENT_ID'),
    'client_secret'         => env('YODLEE_CLIENT_SECRET'),
    'api_ver'               => env('YODLEE_API_VERSION'),
    'fastlink'              => env('YODLEE_FASTLINK'),
    'fastlink_email_ttl'    => 30,
    'sandbox'               => [
        'url'       => 'https://sandbox.api.yodlee.com/ysl',
        'env'       => env('YODLEE_API_URL') === 'https://sandbox.api.yodlee.com/ysl',
        'users'     => [
            'TestUser1' => 'sbMem60acef81b63l01',
            'TestUser2' => 'sbMem60acef81b63l02',
            'TestUser3' => 'sbMem60acef81b63l03',
            'TestUser4' => 'sbMem60acef81b63l04',
            'TestUser5' => 'sbMem60acef81b63l05',
        ],
        'creds'     => [
            'Dag Site'  => [
                'login'     => 'YodTest.site16441.2',
                'pass'      => 'site16441.2',
                'MFA'       => 'None',
            ],
            'Dag Site Multilevel'  => [
                'login'     => 'YodTest.site16442.1',
                'pass'      => 'site16442.1',
                'MFA'       => 'One Time Password: Choose Any Delivery Method (nothing is sent) When prompted enter: 123456',
            ],
            'Dag Site SecurityQA'  => [
                'login'     => 'YodTest.site16486.1',
                'pass'      => 'site16486.1',
                'MFA'       => 'Challenge Questions: Answer 1: w3schools, Answer 2: Texas',
            ],
            'Dag OAuth'  => [
                'login'     => 'YodTest2.site19335.1',
                'pass'      => 'site19335.1',
                'MFA'       => 'None',
            ],
        ],
    ],
];
