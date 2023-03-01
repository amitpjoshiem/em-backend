<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Email Confirmation
    |--------------------------------------------------------------------------
    |
    | When set to true, the user must confirm his email before being able to
    | Login, after his registration.
    |
    */

    'require_email_confirmation' => true,

    /*
    |--------------------------------------------------------------------------
    | The current version of the Passport API routes.
    |--------------------------------------------------------------------------
    */
    'version'                         => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    |
    | A list of clients that have access to the application.
    |
    */

    'clients' => [
        'api'      => [
            'user' => [
                'id'     => env('CLIENT_API_USER_ID'),
                'secret' => env('CLIENT_API_USER_SECRET'),
            ],
        ],
        'api_pkce' => [
            'user' => [
                'id' => env('CLIENT_PKCE_API_USER_ID'),
            ],
        ],

        // add your other clients here
    ],

    /*
    |--------------------------------------------------------------------------
    | Login With Custom Field
    |--------------------------------------------------------------------------
    |
    | This allows you to chose which field you want to use for passport auth.
    |
    */

    'login' => [

        /*
        |--------------------------------------------------------------------------
        | Allowed Login Attributes
        |--------------------------------------------------------------------------
        |
        | A list of fields the user can login with.
        | The key is the field name. The value contains validation rules of the key.
        |
        | The order determines the order the fields are tested to login (in case multiple fields are submitted!
        |
        | Example: 'username' => ['string', 'min:2', 'max:100'],
        |
        */

        'attributes' => [
            'email' => ['email'],
        ],

        /*
        |--------------------------------------------------------------------------
        | Prefix
        |--------------------------------------------------------------------------
        |
        | Use this $prefix variable in order to allow for nested elements.
        | For example, if your login fields are nested in "data.attributes.name / data.attributes.email"
        | simply set the $prefix to "data.attributes."
        |
        */

        'prefix' => '',

    ],

    /*
    |--------------------------------------------------------------------------
    | Login Page Url
    |--------------------------------------------------------------------------
    |
    | unauthorized access on protected web pages will be redirected to this url
    |
    */

    'login-page-url' => 'login',

    // For switch Same Site policy
    'cookie' => [
        'is-allowed-host' => ['localhost'],
        'policy-for-host' => 'none',
    ],

];
