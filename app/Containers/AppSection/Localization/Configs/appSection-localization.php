<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | Get All of supported languages by your Application.
    | You can set the default App language in `config/app.php` as
    | ('locale' => 'en').
    |
    */

    'supported_languages' => [
        'ar',
        'en' => [
            'en-GB',
            'en-US',
        ],
        'zh' => [
            'zh-CN',
        ],
        'es',
        'fr',
        'fa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Force Valid Locale
    |--------------------------------------------------------------------------
    |
    | By default, we validate users Language. However, the user may
    | still request an invalid (i.e., not available) Language. This flag
    | determines, how to proceed in such a case:
    | When set to true, a PHP Exceptions will be thrown (default)
    | When set to false, this invalid Language will be skipped and set to fallback_locale
    |
    */
    'force-valid-locale' => false,

];
