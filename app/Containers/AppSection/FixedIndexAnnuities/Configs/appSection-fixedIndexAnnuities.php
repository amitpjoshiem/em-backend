<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section FixedIndexAnnuities Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'docusign' => [
        'user_email'        => env('DOCUSIGN_USER_EMAIL'),
        'user_id'           => env('DOCUSIGN_USER_ID'),
        'account_id'        => env('DOCUSIGN_ACCOUNT_ID'),
        'user_password'     => env('DOCUSIGN_USER_PASSWORD'),
        'integration_key'   => env('DOCUSIGN_INTEGRATION_KEY'),
        'api_host'          => env('DOCUSIGN_API_URL'),
        'connect_key'       => env('DOCUSIGN_CONNECT_KEY'),
        'auth_code_grant'   => env('DOCUSIGN_AUTH_CODE_GRANT'),
    ],
];
