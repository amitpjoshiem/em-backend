<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Controllers;

use App\Containers\AppSection\AssetsIncome\Actions\CheckRowAction;
use App\Containers\AppSection\AssetsIncome\Actions\ConfirmDataAction;
use App\Containers\AppSection\AssetsIncome\Actions\CreateRowAction;
use App\Containers\AppSection\AssetsIncome\Actions\DeleteRowAction;
use App\Containers\AppSection\AssetsIncome\Actions\GetDataAction;
use App\Containers\AppSection\AssetsIncome\Actions\GetSchemaAction;
use App\Containers\AppSection\AssetsIncome\Actions\SaveDataAction;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\CheckRowRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\ConfirmDataRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\CreateRowRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\DeleteRowRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\GetDataRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\GetSchemaRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Requests\SaveDataRequest;
use App\Containers\AppSection\AssetsIncome\UI\API\Transformers\AssetsIncomeTransformer;
use App\Containers\AppSection\AssetsIncome\UI\API\Transformers\GroupTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getAssetsIncomeSchema(GetSchemaRequest $request): array
    {
        $schema = app(GetSchemaAction::class)->run($request->toTransporter());

        return $this->transform($schema, new GroupTransformer(), resourceKey: 'schema');
    }

    public function getAssetsIncomeData(GetDataRequest $request): array
    {
        $data = app(GetDataAction::class)->run($request->toTransporter());

        return $this->transform($data, new AssetsIncomeTransformer(), resourceKey: 'assetsIncome');
    }

    public function saveAssetsIncomeData(SaveDataRequest $request): array
    {
        $data = app(SaveDataAction::class)->run($request->toTransporter());

        return $this->transform($data, new AssetsIncomeTransformer(), resourceKey: 'assetsIncome');
    }

    public function checkAssetsIncomeRow(CheckRowRequest $request): JsonResponse
    {
        app(CheckRowAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function deleteAssetsIncomeRow(DeleteRowRequest $request): JsonResponse
    {
        app(DeleteRowAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function confirmAssetsIncomeData(ConfirmDataRequest $request): JsonResponse
    {
        app(ConfirmDataAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function createAssetsIncomeRow(CreateRowRequest $request): JsonResponse
    {
        app(CreateRowAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
