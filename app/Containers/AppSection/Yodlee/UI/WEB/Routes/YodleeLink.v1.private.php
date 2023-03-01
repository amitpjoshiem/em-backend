<?php

declare(strict_types=1);

use App\Containers\AppSection\Yodlee\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('yodlee-link', [Controller::class, 'yodleeLink'])
    ->name('web_yodlee_link')
    ->middleware(['signed']);
