<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Project Containers Folder
    |--------------------------------------------------------------------------
    |
    | Specify which folder use for generate documentations
    |
    */

    'root_folder' => base_path('app/Containers'),

    /*
    |--------------------------------------------------------------------------
    | HTML files
    |--------------------------------------------------------------------------
    |
    | Specify where to put the generated HTML files.
    |
    */

    'html_files' => base_path('storage/app/documentation'),

    'postman' => [
        'url' => 'https://www.getpostman.com/collections/f6845d80469f54d2d7eb',
    ],
];
