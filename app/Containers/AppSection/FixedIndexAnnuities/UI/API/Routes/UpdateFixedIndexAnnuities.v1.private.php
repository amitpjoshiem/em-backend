<?php

declare(strict_types=1);

/**
 * @OA\PATCH (
 *     path="/fixed_index_annuities/{id}",
 *     tags={"FixedIndexAnnuities"},
 *     summary="FixedIndexAnnuities",
 *     description="FixedIndexAnnuities",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"fixedindexannuities"},
 *              @OA\Property (property="fixedindexannuities", type="string", example="FixedIndexAnnuities"),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned FixedIndexAnnuities",
 *          @OA\JsonContent(
 *              @OA\Property (property="fixedindexannuities", type="string", example="FixedIndexAnnuities"),
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
 *                      property="fixedindexannuities",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected fixedindexannuities is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('fixed_index_annuities/{id}', [Controller::class, 'updateFixedIndexAnnuities'])
    ->name('api_fixedindexannuities_update_fixed_index_annuities')
    ->middleware(['auth:api', 'user_header']);
