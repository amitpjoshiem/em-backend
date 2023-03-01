<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Controllers;

use App\Containers\AppSection\Blueprint\Actions\GenerateExcelAction;
use App\Containers\AppSection\Blueprint\Actions\GeneratePdfAction;
use App\Containers\AppSection\Blueprint\Actions\GetAllDocsAction;
use App\Containers\AppSection\Blueprint\Actions\GetBlueprintConcernAction;
use App\Containers\AppSection\Blueprint\Actions\GetBlueprintMonthlyIncomeAction;
use App\Containers\AppSection\Blueprint\Actions\GetBlueprintNetWorthAction;
use App\Containers\AppSection\Blueprint\Actions\SaveBlueprintConcernAction;
use App\Containers\AppSection\Blueprint\Actions\SaveBlueprintMonthlyIncomeAction;
use App\Containers\AppSection\Blueprint\Actions\SaveBlueprintNetWorthAction;
use App\Containers\AppSection\Blueprint\Actions\ShareDocAction;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GenerateBlueprintExcelRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GenerateBlueprintPdfRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GetAllBlueprintDocsRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GetBlueprintConcernRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GetBlueprintMonthlyIncomeRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\GetBlueprintNetWorthRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\SaveBlueprintConcernRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\SaveBlueprintMonthlyIncomeRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\SaveBlueprintNetWorthRequest;
use App\Containers\AppSection\Blueprint\UI\API\Requests\ShareBlueprintDocRequest;
use App\Containers\AppSection\Blueprint\UI\API\Transformers\BlueprintConcernTransformer;
use App\Containers\AppSection\Blueprint\UI\API\Transformers\BlueprintDocReportTransformer;
use App\Containers\AppSection\Blueprint\UI\API\Transformers\BlueprintMonthlyIncomeTransformer;
use App\Containers\AppSection\Blueprint\UI\API\Transformers\BlueprintNetWorthTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function saveBlueprintMonthlyIncome(SaveBlueprintMonthlyIncomeRequest $request): array
    {
        $monthlyIncome = app(SaveBlueprintMonthlyIncomeAction::class)->run($request->toTransporter());

        return $this->transform($monthlyIncome, new BlueprintMonthlyIncomeTransformer(), resourceKey: 'monthly_income');
    }

    public function getBlueprintMonthlyIncome(GetBlueprintMonthlyIncomeRequest $request): array
    {
        $monthlyIncome = app(GetBlueprintMonthlyIncomeAction::class)->run($request->toTransporter());

        return $this->transform($monthlyIncome, new BlueprintMonthlyIncomeTransformer(), resourceKey: 'monthly_income');
    }

    public function saveBlueprintConcern(SaveBlueprintConcernRequest $request): array
    {
        $monthlyIncome = app(SaveBlueprintConcernAction::class)->run($request->toTransporter());

        return $this->transform($monthlyIncome, new BlueprintConcernTransformer());
    }

    public function getBlueprintConcern(GetBlueprintConcernRequest $request): array
    {
        $monthlyIncome = app(GetBlueprintConcernAction::class)->run($request->toTransporter());

        return $this->transform($monthlyIncome, new BlueprintConcernTransformer());
    }

    public function getBlueprintNetWorth(GetBlueprintNetWorthRequest $request): array
    {
        $netWorth = app(GetBlueprintNetWorthAction::class)->run($request->toTransporter());

        return $this->transform($netWorth, new BlueprintNetWorthTransformer());
    }

    public function saveBlueprintNetWorth(SaveBlueprintNetWorthRequest $request): array
    {
        $netWorth = app(SaveBlueprintNetWorthAction::class)->run($request->toTransporter());

        return $this->transform($netWorth, new BlueprintNetWorthTransformer());
    }

    public function generatePdf(GenerateBlueprintPdfRequest $request): JsonResponse
    {
        app(GeneratePdfAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function generateExcel(GenerateBlueprintExcelRequest $request): JsonResponse
    {
        app(GenerateExcelAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function shareDoc(ShareBlueprintDocRequest $request): JsonResponse
    {
        app(ShareDocAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllDocs(GetAllBlueprintDocsRequest $request): array
    {
        $docs = app(GetAllDocsAction::class)->run($request->toTransporter());

        return $this->transform($docs, new BlueprintDocReportTransformer());
    }
}
