<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\UI\API\Controllers;

use App\Containers\AppSection\Dashboard\Actions\DashboardMemberListAction;
use App\Containers\AppSection\Dashboard\Actions\DashboardOpportunityAction;
use App\Containers\AppSection\Dashboard\Actions\DashboardPipeLineAction;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DashboardOpportunityRequest;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DashboardPipeLineRequest;
use App\Containers\AppSection\Dashboard\UI\API\Transformers\DashboardMemberListTransformer;
use App\Containers\AppSection\Dashboard\UI\API\Transformers\DashboardOpportunityTransformer;
use App\Containers\AppSection\Dashboard\UI\API\Transformers\DashboardPipelineTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function dashboardOpportunity(DashboardOpportunityRequest $request): array
    {
        $data = app(DashboardOpportunityAction::class)->run($request->toTransporter());

        return $this->transform($data, new DashboardOpportunityTransformer(), resourceKey: 'opportunity');
    }

    public function dashboardPipeLine(DashboardPipeLineRequest $request): array
    {
        $data = app(DashboardPipeLineAction::class)->run($request->toTransporter());

        return $this->transform($data, new DashboardPipelineTransformer(), resourceKey: 'pipeline');
    }

    public function dashboardMemberList(): array
    {
        $data = app(DashboardMemberListAction::class)->run();

        return $this->transform($data, new DashboardMemberListTransformer(), resourceKey: 'member_list');
    }
}
