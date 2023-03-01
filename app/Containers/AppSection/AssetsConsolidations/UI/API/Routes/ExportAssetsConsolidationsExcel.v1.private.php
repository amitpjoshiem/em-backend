<?php

declare(strict_types=1);

/**
 * @OA\Post (
 *     path="/assets_consolidations/{member_id}/export/excel",
 *     tags={"AssetsConsolidations"},
 *     summary="Export AssetsConsolidation Excel",
 *     description="Export AssetsConsolidatio Excel",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Url of AssetsConsolidations Excel",
 *          @OA\JsonContent(
 *              @OA\Property (property="url", type="string", example=""),
 *          )
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

Route::post('assets_consolidations/{member_id}/export/excel', [Controller::class, 'exportExcelAssetsConsolidations'])
    ->name('api_assetsconsolidations_export_excel_assets_consolidations')
    ->middleware(['auth:api', 'user_header']);
