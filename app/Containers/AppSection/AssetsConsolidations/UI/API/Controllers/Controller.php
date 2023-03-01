<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Controllers;

use App\Containers\AppSection\AssetsConsolidations\Actions\ConfirmAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\CreateAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\CreateAssetsConsolidationsTableAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\DeleteAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\ExportExcelAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\GetAllAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\GetAllAssetsConsolidationsDocsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\GetAllAssetsConsolidationsExcelExportsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\UpdateAssetsConsolidationsAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\UpdateAssetsConsolidationsTableAction;
use App\Containers\AppSection\AssetsConsolidations\Actions\UploadAssetsConsolidationsDocsAction;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\ConfirmAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\CreateAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\CreateAssetsConsolidationsTableRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\DeleteAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\ExportExcelAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\GetAllAssetsConsolidationsDocsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\GetAllAssetsConsolidationsExcelExportRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\GetAllAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\UpdateAssetsConsolidationsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\UpdateAssetsConsolidationsTableRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Requests\UploadAssetsConsolidationsDocsRequest;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers\AssetConsolidationDocsTransformer;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers\AssetsConsolidationsExportTransformer;
use App\Containers\AppSection\AssetsConsolidations\UI\API\Transformers\AssetsConsolidationsTableTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createAssetsConsolidations(CreateAssetsConsolidationsRequest $request): array
    {
        $assetsConsolidations = app(CreateAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }

    public function getAllAssetsConsolidations(GetAllAssetsConsolidationsRequest $request): array
    {
        $assetsConsolidations = app(GetAllAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }

    public function updateAssetsConsolidations(UpdateAssetsConsolidationsRequest $request): array
    {
        $assetsConsolidations = app(UpdateAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }

    public function deleteAssetsConsolidations(DeleteAssetsConsolidationsRequest $request): array
    {
        $assetsConsolidations = app(DeleteAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }

    public function confirmAssetsConsolidations(ConfirmAssetsConsolidationsRequest $request): JsonResponse
    {
        app(ConfirmAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function exportExcelAssetsConsolidations(ExportExcelAssetsConsolidationsRequest $request): JsonResponse
    {
        app(ExportExcelAssetsConsolidationsAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllAssetsConsolidationsExcelExports(GetAllAssetsConsolidationsExcelExportRequest $request): array
    {
        $exports = app(GetAllAssetsConsolidationsExcelExportsAction::class)->run($request->toTransporter());

        return $this->transform($exports, new AssetsConsolidationsExportTransformer());
    }

    public function uploadAssetsConsolidationsDocs(UploadAssetsConsolidationsDocsRequest $request): JsonResponse
    {
        app(UploadAssetsConsolidationsDocsAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllAssetsConsolidationsDocs(GetAllAssetsConsolidationsDocsRequest $request): array
    {
        $docs = app(GetAllAssetsConsolidationsDocsAction::class)->run($request->toTransporter());

        return $this->transform($docs, new AssetConsolidationDocsTransformer());
    }

    public function createAssetsConsolidationsTable(CreateAssetsConsolidationsTableRequest $request): array
    {
        $assetsConsolidations = app(CreateAssetsConsolidationsTableAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }

    public function updateAssetsConsolidationsTable(UpdateAssetsConsolidationsTableRequest $request): array
    {
        $assetsConsolidations = app(UpdateAssetsConsolidationsTableAction::class)->run($request->toTransporter());

        return $this->transform($assetsConsolidations, AssetsConsolidationsTableTransformer::class, resourceKey: 'assets_consolidation');
    }
}
