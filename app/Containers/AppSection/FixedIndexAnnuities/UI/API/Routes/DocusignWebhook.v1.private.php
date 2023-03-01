<?php

declare(strict_types=1);

use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('/docusign/webhook', [Controller::class, 'docusignWebhook'])
    ->name('api_docusign_webhook');
