<?php

declare(strict_types=1);

use App\Containers\AppSection\Otp\Services\EmailOtpService;
use App\Containers\AppSection\Otp\Services\GoogleOtpService;
use App\Containers\AppSection\Otp\Services\PhoneOtpService;

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section Otp Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'number_of_digits'      => 6,   // max length of the totp token
    /** @TODO: Change to 300 TTL after finish task + review */
    'totp_ttl'              => 18000, // The lifetime of the generated totp token, in second
    'otp_ttl'               => 18000,
    'skip_otp_routes'       => [
        'api_otp_verify_otp',
        'api_otp_resend_code',
    ],
    'default_service_type'  => EmailOtpService::class,
    'otp_services'          => [
        'google'    => GoogleOtpService::class,
        'email'     => EmailOtpService::class,
        //        'phone'     => PhoneOtpService::class,
    ],
    'resend_otp_services'   => [
        EmailOtpService::class,
        //        PhoneOtpService::class,
    ],
    'auth_routes'           => [
        'login'     => 'api_authentication_client_api_app_login_proxy',
        'refresh'   => 'api_authentication_client_api_app_refresh_proxy',
        'logout'    => 'api_authentication_logout',
    ],
    'otp_cookie_name'       => 'x-otp-token',
    'dev_verify_code'       => '000000',
    'resend_otp_ttl'        => 30,
];
