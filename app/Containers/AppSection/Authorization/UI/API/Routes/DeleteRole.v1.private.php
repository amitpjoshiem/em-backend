<?php

declare(strict_types=1);

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            deleteRole
 *
 * @api                {delete} /v1/roles/:id Delete a Role
 * @apiDescription     Delete Role by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Role
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
 * {
 * "message": "Role (manager) Deleted Successfully."
 * }
 */
Route::delete('roles/{id}', [AuthorizationApiController::class, 'deleteRole'])
    ->name('api_authorization_delete_role')
    ->middleware(['auth:api']);
