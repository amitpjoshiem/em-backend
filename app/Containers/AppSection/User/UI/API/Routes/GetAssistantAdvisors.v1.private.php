<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/advisors",
 *     tags={"User"},
 *     summary="Verify Email",
 *     description="Verify Email by id and token",
 *    @OA\Parameter (
 *          description="User id",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema (type="string"),
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="string value")
 *     ),
 *     @OA\Parameter (
 *          description="token from email link",
 *          name="hash",
 *          in="path",
 *          required=true,
 *          @OA\Schema (type="string"),
 *          @OA\Examples(example="string", value="07f80af4145a...", summary="string value"),
 *     ),
 *     @OA\Parameter (
 *          description="expires from email link",
 *          name="expires",
 *          in="query",
 *          required=true,
 *          @OA\Schema (type="string"),
 *          @OA\Examples(example="string", value="1616000450", summary="string value")
 *     ),
 *     @OA\Parameter (
 *          description="signature from email link",
 *          name="signature",
 *          in="query",
 *          required=true,
 *          @OA\Schema (type="string"),
 *          @OA\Examples(example="string", value="54a2fbc07305a8fde167494...", summary="string value")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="test",
 *         @OA\JsonContent(
 *         ),
 *     ),
 * )
 */
Route::get('/advisors', [UserApiController::class, 'getAssistantAdvisors'])
    ->name('users_get_assistant_advisors')
    ->middleware(['auth:api']);
