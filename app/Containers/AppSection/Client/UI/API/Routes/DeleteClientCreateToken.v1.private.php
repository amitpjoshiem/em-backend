<?php

declare(strict_types=1);

/**
 * @OA\Delete (
 *     path="/clients/token/{member_id}",
 *     tags={"Client"},
 *     summary="Delete Client Email Token",
 *     description="Delete Client Email Token",
 *      @OA\Response(
 *          response=204,
 *          description="Successfully Deleted Token",
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Unprocessable Entity",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="The given data was invalid."),
 *              @OA\Property (
 *                  property="errors",
 *                  type="object",
 *                  @OA\Property(
 *                      property="client",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected client is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Client\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('clients/token/{member_id}', [Controller::class, 'deleteClientToken'])
    ->name('api_client_delete_client_token')
    ->middleware(['auth:api']);
