<?php

declare(strict_types=1);

use App\Containers\AppSection\Yodlee\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/yodlee/{member_id}/providers",
 *     tags={"Yodlee"},
 *     summary="Providers",
 *     description="Get Member Yodlee Providers",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Providers",
 *          @OA\JsonContent(
 *              @OA\Property (property="data", type="array",
 *                  @OA\Items(
 *                      @OA\Property (property="id", type="string", example="lxa986arwqvmbkpn"),
 *                      @OA\Property (property="name", type="string", example="Custom Bank"),
 *                      @OA\Property (property="logo", type="string", example="https://yodlee-1.hs.llnwd.net/v1/LOGO/LOGO_Default.SVG"),
 *                  ),
 *              ),
 *          ),
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
 *              ),
 *          ),
 *      ),
 *  )
 */
Route::get('yodlee/{member_id}/providers', [Controller::class, 'getYodleeProviders'])
    ->name('api_yodlee_get_providers')
    ->middleware(['auth:api', 'user_header']);
