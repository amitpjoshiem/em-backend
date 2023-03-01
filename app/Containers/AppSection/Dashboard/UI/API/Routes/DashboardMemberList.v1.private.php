<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/dashboard/members/list",
 *     tags={"Dashboard"},
 *     summary="Member List",
 *     description="Get Member List With Opportunity For Dashboard",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member List",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="name", type="string", example="Member name"),
 *                      @OA\Property(property="type", type="string", example="prospect"),
 *                      @OA\Property(property="stage", type="string", example="1st Appointment"),
 *                      @OA\Property(property="amount", type="float", example="99862.018")
 *                  )
 *              ),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      )
 *  )
 */

use App\Containers\AppSection\Dashboard\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('dashboard/members/list', [Controller::class, 'dashboardMemberList'])
    ->name('api_dashboard_member_list')
    ->middleware(['auth:api', 'user_header']);
