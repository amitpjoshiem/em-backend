<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    |
    | Insert your allowed reset password urls to inject into the email.
    |
    */
    'allowed-reset-password-urls'   => [
        'password-reset',
    ],
    'phone_code_cache_key'          => 'phone:%s',
    'user_status_key'               => 'user:status:%s',
    'phone_expire_warning_days'     => 14,
    'phone_expire_days'             => 90,
    'reset_password_link'           => 'login/password-reset',
];
