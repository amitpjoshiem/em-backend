<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('salesforce/auth/logout', [Controller::class, 'authLogout'])
    ->name('api_salesforce_auth_logout')
    ->middleware(['auth:api']);
