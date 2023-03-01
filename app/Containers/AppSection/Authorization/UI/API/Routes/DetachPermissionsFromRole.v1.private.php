<?php

declare(strict_types=1);

/**
 * @apiGroup           RolePermission
 * @apiName            detachPermissionFromRole
 *
 * @api                {post} /v1/permissions/detach Detach Permissions from Role
 * @apiDescription     Detach existing permission from role. This endpoint does not sync the role
 *                     It just detach the passed permissions from the role. So make sure
 *                     to never send an non attached permission since it will cause an error.
 *                     To sync (update) all existing permissions with the new ones use
 *                     `/permissions/sync` endpoint instead.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String} role_id Role ID
 * @apiParam           {String-Array} permissions_ids Permission ID or Array of Permissions ID's
 *
 * @apiUse             RoleSuccessSingleResponse
 */

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

Route::post('permissions/detach', [AuthorizationApiController::class, 'detachPermissionFromRole'])
    ->name('api_authorization_detach_permission_from_role')
    ->middleware(['auth:api']);
