<?php

declare(strict_types=1);

use App\Containers\AppSection\Documentation\UI\WEB\Controllers\Controller as DocsWebController;
use Illuminate\Routing\Router;

Route::group([
    'prefix'     => '/docs',
    'middleware' => [
        'throttle:60,1',
    ],
], function (Router $route) {
    $route->get('/old-swagger-collection', [DocsWebController::class, 'getOldSwaggerCollection'])
        ->name('documentation-page-old-swagger-collection');
    $route->get('/postman-collection', [DocsWebController::class, 'getPostmanCollection'])
        ->name('documentation-postman-collection');
    $route->get('/swagger-collection', [DocsWebController::class, 'getSwaggerCollection'])
        ->name('documentation-swagger-collection');
    $route->get('/swagger', [DocsWebController::class, 'showSwaggerPage'])
        ->name('documentation-page-swagger-collection');
});
