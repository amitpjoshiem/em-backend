<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/companies",
 *     tags={"User"},
 *     summary="Get All Companies",
 *     description="Get All Companies",
 *     @OA\Response(
 *         response=200,
 *         description="Returned All Companies",
 *     ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *  )
 */
Route::get('companies', [UserApiController::class, 'getAllCompanies'])
    ->name('api_user_get_all_companies')
    ->middleware(['auth:api']);
