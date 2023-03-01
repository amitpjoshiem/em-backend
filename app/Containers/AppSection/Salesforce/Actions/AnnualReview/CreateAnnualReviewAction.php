<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions\AnnualReview;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\CreateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceCreateException;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\CreateSalesforceAnnualReviewTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use JsonException;

class CreateAnnualReviewAction extends Action
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
    public function run(int $memberId, CreateSalesforceAnnualReviewTransporter $input): SalesforceAnnualReview
    {
        $member  = app(FindMemberByIdTask::class)->withRelations(['salesforce'])->run($memberId);

        $annualReview = app(CreateSalesforceAnnualReviewTask::class)->run(
            $member->getKey(),
            $member->salesforce->getKey(),
            $input,
        );

        $annualReview->api()->create();

        return $annualReview;
    }
}
