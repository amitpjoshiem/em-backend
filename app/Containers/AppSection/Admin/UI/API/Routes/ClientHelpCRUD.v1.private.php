<?php

declare(strict_types=1);

use App\Containers\AppSection\Admin\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])
    ->prefix('admin/clients/help')
    ->name('api_admin_clients_help_')
    ->group(function () {
        /**
         * @OA\Get (
         *     path="admin/clients/help",
         *     tags={"Admin"},
         *     summary="Get All Client Help",
         *     description="Get All Client Help",
         *      @OA\Response(
         *          response=204,
         *          description="Return Client Help list",
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::get('', [Controller::class, 'getAllClientHelp'])
            ->name('get_all');
        /**
         * @OA\Get (
         *     path="/admin/clients/help/find/{type}",
         *     tags={"Admin"},
         *     summary="Admin Get Client Help By Type",
         *     description="Admin Get Client Help By Type",
         *     @OA\Parameter(
         *          description="Type",
         *          name="type",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="prospect_basic", summary="type")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Return Client Help",
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::get('find/{type}', [Controller::class, 'getClientHelpByType'])
            ->name('find_by_type');

        /**
         * @OA\Patch (
         *     path="/admin/clients/help/{type}",
         *     tags={"Admin"},
         *     summary="Admin Change Client Help",
         *     description="Admin Change Client Help",
         *     @OA\Parameter(
         *          description="Type",
         *          name="type",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="prospect_basic", summary="type")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Return Client Help",
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::patch('/{type}', [Controller::class, 'updateClientHelp'])
            ->name('update_client_help');

        /**
         * @OA\Delete (
         *     path="/admin/clients/help/{type}",
         *     tags={"Admin"},
         *     summary="Admin Delete Client Help Video",
         *     description="Admin Delete Client Help Video",
         *     @OA\Parameter(
         *          description="Type",
         *          name="type",
         *          in="query",
         *          required=true,
         *          @OA\Examples(example="string", value="prospect_basic", summary="type")
         *     ),
         *      @OA\Response(
         *          response=204,
         *          description="Return Client Help",
         *      ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthorized",
         *          @OA\JsonContent(
         *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
         *          ),
         *      ),
         *  )
         */
        Route::delete('/{type}', [Controller::class, 'deleteHelpVideo'])
            ->name('delete_help_video');
    });
