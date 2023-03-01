<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @apiGroup           Users
 * @apiName            updateUser
 *
 * @api                {patch} /v1/users/:id Update User
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  password (optional)
 * @apiParam           {String}  username (optional)
 */
Route::patch('users/{id}', [UserApiController::class, 'updateUser'])
    ->name('api_user_update_user')
    ->middleware(['auth:api']);
