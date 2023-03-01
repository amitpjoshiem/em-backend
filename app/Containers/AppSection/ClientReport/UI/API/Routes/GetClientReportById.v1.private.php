<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/client_reports/{id}",
 *     tags={"ClientReports"},
 *     summary="Get ClientReport By ID",
 *     description="Get ClientReport By ID",
 *      @OA\Response(
 *          response=200,
 *          description="Returned ClientReport",
 *          @OA\JsonContent(
 *              @OA\Property (property="clientreport", type="string", example="ClientReport"),
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
 *                      property="clientreport",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected clientreport is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\ClientReport\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('client_reports/{id}', [Controller::class, 'getClientReportById'])
    ->name('api_clientreport_get_by_id')
    ->middleware(['auth:api', 'user_header']);
