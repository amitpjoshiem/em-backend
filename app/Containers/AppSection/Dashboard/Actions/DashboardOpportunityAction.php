<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Authorization\Data\Enums\RolesEnum;
use App\Containers\AppSection\Dashboard\Data\Transporters\DashboardOpportunityTransporter;
use App\Containers\AppSection\Dashboard\Tasks\GetPreparedOpportunityData;
use App\Containers\AppSection\Dashboard\Tasks\GetSortedOpportunityData;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunitiesByCompanyIdTask;
use App\Containers\AppSection\Salesforce\Tasks\ChildOpportunity\FindSalesforceChildOpportunitiesByUserIdTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCompanyByHelperOrUserTask;
use App\Ship\Parents\Actions\Action;
use stdClass;

class DashboardOpportunityAction extends Action
{
    /**
     * @var array<string, array<string, string>>
     */
    public const SORT_TYPES = [
        'year'      => [
            'format'          => 'Y-m',
            'iterator'        => 'month',
            'outputFormat'    => 'M',
        ],
        'quarter'   => [
            'format'          => 'W',
            'iterator'        => 'week',
            'outputFormat'    => 'W',
        ],
        'month'     => [
            'format'          => 'Y-m-d',
            'iterator'        => 'day',
            'outputFormat'    => 'd',
        ],
    ];

    public function __construct(protected SalesforceApiService $salesforceApiService)
    {
    }

    public function run(DashboardOpportunityTransporter $input): stdClass
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        $childOpportunities = collect();

        if ($user->hasRole(RolesEnum::ADVISOR)) {
            $childOpportunities = app(FindSalesforceChildOpportunitiesByUserIdTask::class)
                ->run($user->getKey());
        }

        if ($user->hasRole([RolesEnum::CEO, RolesEnum::ADMIN])) {
            $companyId          = app(GetCompanyByHelperOrUserTask::class)->run($user);
            $childOpportunities = app(FindSalesforceChildOpportunitiesByCompanyIdTask::class)
                ->run($companyId);
        }

        $data                  = ['values' => app(GetPreparedOpportunityData::class)->run($input->type)];

        return app(GetSortedOpportunityData::class)->run($childOpportunities, $input->type, $data);
    }
}
