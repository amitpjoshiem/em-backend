<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('login', [Controller::class, 'showLoginPage'])
    ->name(config('appSection-authentication.login-page-url'))
    ->middleware(['guest']);
