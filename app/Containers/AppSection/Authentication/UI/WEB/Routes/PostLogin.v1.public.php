<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('login', [Controller::class, 'login'])
    ->name('login_post_form')
    ->middleware(['throttle:login']);
