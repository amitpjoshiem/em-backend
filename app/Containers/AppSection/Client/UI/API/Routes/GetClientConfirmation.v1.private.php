<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/clients/confirmation",
 *     tags={"Client"},
 *     summary="Save Client Confirmation",
 *     description="Save Client Confirmation",
 *      @OA\Response(
 *          response=204,
 *          description="Returned Client Confirmation",
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

Route::get('clients/confirmation', [Controller::class, 'getClientConfirmation'])
    ->name('api_client_get_client_confirmation')
    ->middleware(['auth:api', 'user_header']);
