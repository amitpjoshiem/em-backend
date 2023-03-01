<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Controllers;

use App\Containers\AppSection\FixedIndexAnnuities\Actions\CreateFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\CreateInvestmentPackageAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\DeleteFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\DeleteInvestmentPackageAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\DocusignWebhookAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\FindFixedIndexAnnuitiesByIdAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\FindInvestmentPackageAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\GetAllFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\GetAllInvestmentPackagesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\InitFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\SignFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\SignInvestmentPackageAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\UpdateFixedIndexAnnuitiesAction;
use App\Containers\AppSection\FixedIndexAnnuities\Actions\UpdateInvestmentPackageAction;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\CreateFixedIndexAnnuitiesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\CreateInvestmentPackageRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\DeleteFixedIndexAnnuitiesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\DeleteInvestmentPackageRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\DocusignWebHookRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\FindFixedIndexAnnuitiesByIdRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\FindInvestmentPackageRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\GetAllFixedIndexAnnuitiesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\GetAllInvestmentPackagesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\SignFixedIndexAnnuitiesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\SignInvestmentPackageRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\UpdateFixedIndexAnnuitiesRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests\UpdateInvestmentPackageRequest;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Transformers\FixedIndexAnnuitiesTransformer;
use App\Containers\AppSection\FixedIndexAnnuities\UI\API\Transformers\InvestmentPackageTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createFixedIndexAnnuities(CreateFixedIndexAnnuitiesRequest $request): JsonResponse
    {
        $fixedIndexAnnuities = app(CreateFixedIndexAnnuitiesAction::class)->run($request->toTransporter());

        return $this->created($this->transform($fixedIndexAnnuities, FixedIndexAnnuitiesTransformer::class));
    }

    public function findFixedIndexAnnuitiesById(FindFixedIndexAnnuitiesByIdRequest $request): array
    {
        $fixedIndexAnnuities = app(FindFixedIndexAnnuitiesByIdAction::class)->run($request->toTransporter());

        return $this->transform($fixedIndexAnnuities, FixedIndexAnnuitiesTransformer::class);
    }

    public function getAllFixedIndexAnnuities(GetAllFixedIndexAnnuitiesRequest $request): array
    {
        $fixedIndexAnnuities = app(GetAllFixedIndexAnnuitiesAction::class)->run($request->toTransporter());

        return $this->transform($fixedIndexAnnuities, FixedIndexAnnuitiesTransformer::class);
    }

    public function updateFixedIndexAnnuities(UpdateFixedIndexAnnuitiesRequest $request): array
    {
        $fixedIndexAnnuities = app(UpdateFixedIndexAnnuitiesAction::class)->run($request->toTransporter());

        return $this->transform($fixedIndexAnnuities, FixedIndexAnnuitiesTransformer::class);
    }

    public function deleteFixedIndexAnnuities(DeleteFixedIndexAnnuitiesRequest $request): JsonResponse
    {
        app(DeleteFixedIndexAnnuitiesAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function signFixedIndexAnnuities(SignFixedIndexAnnuitiesRequest $request): JsonResponse
    {
        $data = app(SignFixedIndexAnnuitiesAction::class)->run($request->toTransporter());

        return $this->json(['data' => $data]);
    }

    public function initFixedIndexAnnuities(): JsonResponse
    {
        $init = app(InitFixedIndexAnnuitiesAction::class)->run();

        return $this->json(['data' => $init]);
    }

    public function createInvestmentPackage(CreateInvestmentPackageRequest $request): array
    {
        $investmentPackage = app(CreateInvestmentPackageAction::class)->run($request->toTransporter());

        return $this->transform($investmentPackage, new InvestmentPackageTransformer());
    }

    public function updateInvestmentPackage(UpdateInvestmentPackageRequest $request): array
    {
        $investmentPackage = app(UpdateInvestmentPackageAction::class)->run($request->toTransporter());

        return $this->transform($investmentPackage, new InvestmentPackageTransformer());
    }

    public function findInvestmentPackage(FindInvestmentPackageRequest $request): array
    {
        $investmentPackage = app(FindInvestmentPackageAction::class)->run($request->toTransporter());

        return $this->transform($investmentPackage, new InvestmentPackageTransformer());
    }

    public function getAllInvestmentPackages(GetAllInvestmentPackagesRequest $request): array
    {
        $investmentPackages = app(GetAllInvestmentPackagesAction::class)->run($request->toTransporter());

        return $this->transform($investmentPackages, new InvestmentPackageTransformer(), resourceKey: 'InvestmentPackages');
    }

    public function deleteInvestmentPackage(DeleteInvestmentPackageRequest $request): JsonResponse
    {
        app(DeleteInvestmentPackageAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function signInvestmentPackage(SignInvestmentPackageRequest $request): JsonResponse
    {
        $data = app(SignInvestmentPackageAction::class)->run($request->toTransporter());

        return $this->json(['data' => $data]);
    }

    public function docusignWebhook(DocusignWebHookRequest $request): JsonResponse
    {
        app(DocusignWebhookAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
