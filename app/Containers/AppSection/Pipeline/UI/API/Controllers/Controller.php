<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Pipeline\UI\API\Controllers;

use App\Containers\AppSection\Pipeline\Actions\GetPipelineAUMAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineClosedWinLostAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineConvertedLeadsAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineCreatedLeadsAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineInputLeadsAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineMemberAgeAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineMemberCountAction;
use App\Containers\AppSection\Pipeline\Actions\GetPipelineMemberRetiredAction;
use App\Containers\AppSection\Pipeline\UI\API\Requests\PipelinePeriodTypeRequest;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineAumTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineClientCountTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineClosedWinLostTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineLeadConvertedTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineLeadInputTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineMemberAgeTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineMemberCountTransformer;
use App\Containers\AppSection\Pipeline\UI\API\Transformers\PipelineMemberRetiredTransformer;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getAUM(): array
    {
        $data = app(GetPipelineAUMAction::class)->run();

        return $this->transform($data, new PipelineAumTransformer(), resourceKey: 'aum');
    }

    public function getMemberAge(): array
    {
        $data = app(GetPipelineMemberAgeAction::class)->run();

        return $this->transform($data, new PipelineMemberAgeTransformer(), resourceKey: 'age');
    }

    public function getMemberCount(): array
    {
        $data = app(GetPipelineMemberCountAction::class)->run();

        return $this->transform($data, new PipelineMemberCountTransformer(), resourceKey: 'count');
    }

    public function getMemberRetired(): array
    {
        $data = app(GetPipelineMemberRetiredAction::class)->run();

        return $this->transform($data, new PipelineMemberRetiredTransformer(), resourceKey: 'retired');
    }

    public function GetCreatedLeads(PipelinePeriodTypeRequest $request): array
    {
        $data = app(GetPipelineCreatedLeadsAction::class)->run($request->toTransporter());

        return $this->transform($data, new PipelineClientCountTransformer(), resourceKey: 'createdLeads');
    }

    public function GetConvertedLeads(PipelinePeriodTypeRequest $request): array
    {
        $data = app(GetPipelineConvertedLeadsAction::class)->run($request->toTransporter());

        return $this->transform($data, new PipelineLeadConvertedTransformer(), resourceKey: 'convertedLeads');
    }

    public function GetInputLeads(PipelinePeriodTypeRequest $request): array
    {
        $data = app(GetPipelineInputLeadsAction::class)->run($request->toTransporter());

        return $this->transform($data, new PipelineLeadInputTransformer(), resourceKey: 'inputLeads');
    }

    public function GetClosedWinLost(PipelinePeriodTypeRequest $request): array
    {
        $data = app(GetPipelineClosedWinLostAction::class)->run($request->toTransporter());

        return $this->transform($data, new PipelineClosedWinLostTransformer(), resourceKey: 'closedWinLost');
    }
}
