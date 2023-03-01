<?php

declare(strict_types=1);

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            attachPermissionToRole
 *
 * @api                {post} /v1/permissions/attach Attach Permissions to Role
 * @apiDescription     Attach new permissions to role. This endpoint does not sync the role with the
 *                     new permissions. It simply attach new permission to the role. So make sure
 *                     to never send an already attached permission since it will cause an error.
 *                     To sync (update) all existing permissions with the new ones use
 *                     `/permissions/sync` endpoint instead.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String} role_id Role ID
 * @apiParam           {Array} permissions_ids Permission ID or Array of Permissions ID's
 *
 * @apiUse             RoleSuccessSingleResponse
 */
Route::post('permissions/attach', [AuthorizationApiController::class, 'attachPermissionToRole'])
    ->name('api_authorization_attach_permission_to_role')
    ->middleware(['auth:api']);
