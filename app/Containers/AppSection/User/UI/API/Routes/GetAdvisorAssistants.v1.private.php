<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/assistants",
 *     tags={"User"},
 *     summary="Get all Advisor Assistants",
 *     description="Get all Advisor Assistants",
 *     @OA\Response(
 *         response=204,
 *         description="test",
 *         @OA\JsonContent(
 *         ),
 *     ),
 * )
 */
Route::get('/assistants', [UserApiController::class, 'getAdvisorAssistants'])
    ->name('users_get_advisor_assistants')
    ->middleware(['auth:api']);
