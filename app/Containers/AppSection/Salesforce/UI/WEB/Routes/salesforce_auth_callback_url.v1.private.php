<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('salesforce/auth/callback', [Controller::class, 'authCallback'])
    ->name('web_salesforce_auth_callback');
