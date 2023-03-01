<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('logout', [Controller::class, 'logout'])
    ->name('post_logout');
