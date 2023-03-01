<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Controllers;

use App\Containers\AppSection\Media\Actions\CreateTemporaryUploadMediaAction;
use App\Containers\AppSection\Media\Actions\DeleteMediaAction;
use App\Containers\AppSection\Media\Actions\GetAllMediaByTemporaryUploadUuidsAction;
use App\Containers\AppSection\Media\Actions\GetCollectionMediaRulesAction;
use App\Containers\AppSection\Media\UI\API\Requests\CreateTemporaryUploadMediaRequest;
use App\Containers\AppSection\Media\UI\API\Requests\DeleteMediaRequest;
use App\Containers\AppSection\Media\UI\API\Requests\GetAllMediaByTemporaryUploadUuidsRequest;
use App\Containers\AppSection\Media\UI\API\Requests\GetCollectionMediaRulesRequest;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaRulesTransformer;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaTransformer;
use App\Containers\AppSection\Media\UI\API\Transformers\TemporaryUploadTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createTemporaryUploadMedia(CreateTemporaryUploadMediaRequest $request): JsonResponse
    {
        $temporaryUpload = app(CreateTemporaryUploadMediaAction::class)->run($request->toTransporter());

        return $this->created($this->transform($temporaryUpload, TemporaryUploadTransformer::class));
    }

    public function GetAllMediaByTemporaryUploadUuids(GetAllMediaByTemporaryUploadUuidsRequest $request): array
    {
        $media = app(GetAllMediaByTemporaryUploadUuidsAction::class)->run($request->toTransporter());

        return $this->transform($media, MediaTransformer::class);
    }

    public function deleteMedia(DeleteMediaRequest $request): JsonResponse
    {
        app(DeleteMediaAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getCollectionMediaRules(GetCollectionMediaRulesRequest $request): array
    {
        $rules = app(GetCollectionMediaRulesAction::class)->run($request->toTransporter());

        return $this->transform($rules, new MediaRulesTransformer(), resourceKey: 'rules');
    }
}
