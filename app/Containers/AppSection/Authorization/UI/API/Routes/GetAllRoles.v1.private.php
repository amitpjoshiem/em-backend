<?php

declare(strict_types=1);

/**
 * @apiGroup           RolePermission
 * @apiName            getAllRoles
 *
 * @api                {get} /v1/roles Get All Roles
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

Route::get('roles', [AuthorizationApiController::class, 'getAllRoles'])
    ->name('api_authorization_get_all_roles')
    ->middleware(['auth:api']);
