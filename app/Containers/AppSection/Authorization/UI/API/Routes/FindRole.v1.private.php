<?php

declare(strict_types=1);

/**
 * @apiGroup           RolePermission
 * @apiName            getRole
 *
 * @api                {get} /v1/roles/:id Find a Role by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             RoleSuccessSingleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

Route::get('roles/{id}', [AuthorizationApiController::class, 'findRole'])
    ->name('api_authorization_get_role')
    ->middleware(['auth:api']);
