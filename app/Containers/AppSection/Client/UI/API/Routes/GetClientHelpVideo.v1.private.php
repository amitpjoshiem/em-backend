<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/clients/help/{page}",
 *     tags={"Client"},
 *     summary="Client Help Video",
 *     description="Client Help Video",
 *     @OA\Parameter(
 *          description="Page",
 *          name="page",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="update_info", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Video Url",
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
 *                      property="assetsconsolidations",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected assetsconsolidations is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Client\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/clients/help/{page}', [Controller::class, 'helpClientVideo'])
    ->name('api_client_help_client_video')
    ->middleware(['auth:api']);
