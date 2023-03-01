<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\Account;

use App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Carbon\CarbonImmutable;
use JsonException;

class GetUpdatedAccountsAction extends Action
{
    public function __construct(protected SalesforceApiService $apiService)
    {
    }

    /**
     * @throws NotFoundException
     * @throws SalesforceCreateException
     * @throws UserNotFoundException
     * @throws JsonException
     * @throws CreateResourceFailedException
     */
    public function run(CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        $content = $this->apiService->account()->getUpdated($startDate, $endDate);

        return $content['ids'] ?? [];
    }
}
