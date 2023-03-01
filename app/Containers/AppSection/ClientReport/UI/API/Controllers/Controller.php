<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Controllers;

use App\Containers\AppSection\ClientReport\Actions\CreateClientReportAction;
use App\Containers\AppSection\ClientReport\Actions\DeleteClientReportAction;
use App\Containers\AppSection\ClientReport\Actions\GenerateClientReportsExcelAction;
use App\Containers\AppSection\ClientReport\Actions\GenerateClientReportsPdfAction;
use App\Containers\AppSection\ClientReport\Actions\GetAllClientReportsAction;
use App\Containers\AppSection\ClientReport\Actions\GetAllClientReportsDocsAction;
use App\Containers\AppSection\ClientReport\Actions\GetClientReportAction;
use App\Containers\AppSection\ClientReport\Actions\ShareDocAction;
use App\Containers\AppSection\ClientReport\Actions\UpdateClientReportAction;
use App\Containers\AppSection\ClientReport\UI\API\Requests\CreateClientReportRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\DeleteClientReportRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\GenerateClientReportsExcelRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\GenerateClientReportsPdfRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\GetAllClientReportsDocsRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\GetAllClientReportsRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\GetClientReportRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\ShareClientReportDocRequest;
use App\Containers\AppSection\ClientReport\UI\API\Requests\UpdateClientReportRequest;
use App\Containers\AppSection\ClientReport\UI\API\Transformers\ClientReportDocTransformer;
use App\Containers\AppSection\ClientReport\UI\API\Transformers\ClientReportTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getClientReports(GetAllClientReportsRequest $request): array
    {
        $clientReports = app(GetAllClientReportsAction::class)->run($request->toTransporter());

        return $this->transform($clientReports, ClientReportTransformer::class, resourceKey: 'client_report');
    }

    public function getClientReportById(GetClientReportRequest $request): array
    {
        $clientReport = app(GetClientReportAction::class)->run($request->toTransporter());

        return $this->transform($clientReport, ClientReportTransformer::class, resourceKey: 'client_report');
    }

    public function generateClientReportPdf(GenerateClientReportsPdfRequest $request): JsonResponse
    {
        app(GenerateClientReportsPdfAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function generateClientReportExcel(GenerateClientReportsExcelRequest $request): JsonResponse
    {
        app(GenerateClientReportsExcelAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function shareDoc(ShareClientReportDocRequest $request): JsonResponse
    {
        app(ShareDocAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getAllClientReportDocs(GetAllClientReportsDocsRequest $request): array
    {
        $docs = app(GetAllClientReportsDocsAction::class)->run($request->toTransporter());

        return $this->transform($docs, new ClientReportDocTransformer());
    }

    public function createClientReport(CreateClientReportRequest $request): array
    {
        $clientReport = app(CreateClientReportAction::class)->run($request->toTransporter());

        return $this->transform($clientReport, new ClientReportTransformer());
    }

    public function updateClientReport(UpdateClientReportRequest $request): array
    {
        $clientReport = app(UpdateClientReportAction::class)->run($request->toTransporter());

        return $this->transform($clientReport, new ClientReportTransformer());
    }

    public function deleteClientReport(DeleteClientReportRequest $request): JsonResponse
    {
        app(DeleteClientReportAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
