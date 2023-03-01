### Otp Container

Container implement 2FA for Authenticate logic.

it has two 2FA services email and google.

Integration steps in Apiato project:
1. Clone container to your AppSection.
2. Add to .env `OTP_ENABLED=true`.
3. Add to config/auth.php `'otp' => env('OTP_ENABLED'),`.
4. In Otp Container config set your `auth_routes` names, and if you need change otp config for your application.
5. Fresh migrations and Clear Cache.
6. For Success All PHPUnit tests you need to add in your phpunit.xml
`<server name="OTP_ENABLED" value="false"/>`
7. For executing self Otp PHPUnit change Otp/phpunit.xml to your .env variables.
Add to your executing phpunit script code below.
   
`"find ./app/Containers -type f -name 'phpunit.xml' -exec ./vendor/bin/phpunit --configuration '{}' \\;"`
8. Add your custom email template for code sending in Otp/Mails/Templates/otp.blade.php
