<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    |
    | Insert your reset password url to inject into the email.
    |
    */
    'allowed-reset-password-url' => '/login/password-reset',

    /*
    |--------------------------------------------------------------------------
    | Verification Email
    |--------------------------------------------------------------------------
    |
    | Part of verification email urls to inject into the email.
    |
    */
    'email-verify-url' => '/verify-email',
];
