<?php

declare(strict_types=1);

/**
 * @apiGroup           RolePermission
 * @apiName            getAllPermissions
 *
 * @api                {get} /v1/permissions Get All Permission
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

Route::get('permissions', [AuthorizationApiController::class, 'getAllPermissions'])
    ->name('api_authorization_get_all_permissions')
    ->middleware(['auth:api']);
