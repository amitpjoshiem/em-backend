<?php

declare(strict_types=1);

/**
 * @apiGroup           RolePermission
 * @apiName            getPermission
 *
 * @api                {get} /v1/permissions/:id Find a Permission by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             PermissionSuccessSingleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

Route::get('permissions/{id}', [AuthorizationApiController::class, 'findPermission'])
    ->name('api_authorization_get_permission')
    ->middleware(['auth:api']);
