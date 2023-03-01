<?php

declare(strict_types=1);

/**
 * @OA\Patch (
 *     path="/assets_consolidations/{id}",
 *     tags={"AssetsConsolidations"},
 *     summary="Update AssetsConsolidation",
 *     description="Update AssetsConsolidation By ID",
 *     @OA\Parameter(
 *          description="AssetsConsolidations ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/AssetsConsolidationsInput")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned AssetsConsolidations",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/AssetsConsolidationsOutput")
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

Route::patch('assets_consolidations/{id}', [Controller::class, 'updateAssetsConsolidations'])
    ->name('api_assetsconsolidations_update_assets_consolidations')
    ->middleware(['auth:api', 'user_header']);
