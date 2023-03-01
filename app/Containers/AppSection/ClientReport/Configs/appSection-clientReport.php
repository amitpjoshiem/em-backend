<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section ClientReport Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'admin_email'                   => env('ADMIN_EMAIL', 'admin@admin.com'),
    'import_processed_directory'    => 'client_reports/processed',
    'import_directory'              => 'client_reports',
    'pdf_report_tmp_path'           => sys_get_temp_dir(),
    'reports_per_page'              => 4,
    'client_report_docs_front_url'  => '/advisor/blueprint-docs/%s/%s',

];
