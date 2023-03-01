<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\GET (
 *     path="/salesforce/auth/settings",
 *     tags={"Salesforce User"},
 *     summary="Get User Auth Settings",
 *     description="Get Info for login User in Salesforce",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Settings",
 *          @OA\JsonContent(
 *              @OA\Property (property="auth", type="bool", example=false),
 *              @OA\Property (property="link", type="string", example="https://swdgroup--stats.my.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9_I_oWkIqLrmYTMNjoKOWZ350mChn99xTMiooRKTEeVnoEmy_EPWmKpGkPlfFAxEtMb6kS6e0Dw.7gRGg&redirect_uri=http%3A%2F%2Flocalhost%2Fsalesforce%2Fauth%2Fcallback&state=kvlx58rlk76zn3ej"),
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
 *          ),
 *      ),
 *  )
 */
Route::get('salesforce/auth/settings', [Controller::class, 'authSettings'])
    ->name('api_salesforce_auth_settings')
    ->middleware(['auth:api']);
