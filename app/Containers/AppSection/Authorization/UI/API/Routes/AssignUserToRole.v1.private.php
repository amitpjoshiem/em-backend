<?php

declare(strict_types=1);

use App\Containers\AppSection\Authorization\UI\API\Controllers\Controller as AuthorizationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           RolePermission
 * @apiName            assignUserToRole
 *
 * @api                {post} /v1/roles/assign Assign User to Roles
 * @apiDescription     Assign new roles to user. This endpoint does not sync the user with the
 *                     new roles. It simply assign new role to the user. So make sure
 *                     to never send an already assigned role since it will cause an error.
 *                     To sync (update) all existing roles with the new ones use
 *                     `/roles/sync` endpoint instead.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Number} user_id User ID
 * @apiParam           {Array} roles_ids Role ID or Array of Roles ID's
 *
 * @apiUse             UserSuccessSingleResponse
 */
Route::post('roles/assign', [AuthorizationApiController::class, 'assignUserToRole'])
    ->name('api_authorization_assign_user_to_role')
    ->middleware(['auth:api']);
