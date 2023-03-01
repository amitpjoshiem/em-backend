<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/salesforce/opportunity/convert/cancel/{member_id}",
 *     tags={"Salesforce"},
 *     summary="Cancel Auto Converting to Close Win",
 *     description="Cancel Auto Converting to Close Win",
 *      @OA\Response(
 *          response=204,
 *          description="Returned Status",
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
 *          ),
 *      ),
 *  )
 */
Route::post('/salesforce/opportunity/convert/cancel/{member_id}', [Controller::class, 'cancelConvertCloseWin'])
    ->name('api_salesforce_cancel_convert_close_win')
    ->middleware(['auth:api', 'user_header']);
