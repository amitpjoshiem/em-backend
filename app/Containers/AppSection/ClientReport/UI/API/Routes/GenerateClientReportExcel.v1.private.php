<?php

declare(strict_types=1);

/**
 * @OA\Post (
 *     path="/client_reports/excel/{member_id}",
 *     tags={"ClientReports Docs"},
 *     summary="Generate ClientReport PDF",
 *     description="Generate ClientReport PDF",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Start Generating",
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

Route::post('client_reports/excel/{member_id}', [Controller::class, 'generateClientReportExcel'])
    ->name('api_clientreport_get_excel')
    ->middleware(['auth:api', 'user_header']);
