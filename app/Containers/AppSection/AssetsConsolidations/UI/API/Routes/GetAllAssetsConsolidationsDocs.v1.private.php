<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/assets_consolidations/{member_id}/docs",
 *     tags={"AssetsConsolidations"},
 *     summary="Get All AssetsConsolidation Docs",
 *     description="Get All AssetsConsolidation Docs",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Confirmed AssetsConsolidations",
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

use App\Containers\AppSection\AssetsConsolidations\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('assets_consolidations/{member_id}/docs', [Controller::class, 'getAllAssetsConsolidationsDocs'])
    ->name('api_assetsconsolidations_get_all_assets_consolidations_docs')
    ->middleware(['auth:api', 'user_header']);
