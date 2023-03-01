<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\AnnualReview;

use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\CreateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Data\Transporters\AnnualReviewTransporters\UpdateSalesforceAnnualReviewTransporter;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\CreateSalesforceAnnualReviewTask;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\FindSalesforceAnnualReviewBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\AnnualReview\UpdateSalesforceAnnualReviewBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Carbon;
use function app;

class SaveImportedAnnualReviewSubAction extends SubAction implements SaveImportedObjectInterface
{
    public function run(array $info, string $objectId, ?int $userId = null): void
    {
        if ($info['Client_Account__c'] === null) {
            app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::ANNUAL_REVIEW, $info['Id'], $info['OwnerId']);

            return;
        }

        $account = app(FindSalesforceAccountBySalesforceIdTask::class)->run($info['Client_Account__c']);

        if ($account === null) {
            app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::ANNUAL_REVIEW, $info['Id'], $info['OwnerId']);

            return;
        }

        $salesforceAnnualReview = app(FindSalesforceAnnualReviewBySalesforceIdTask::class)->run($objectId);

        if ($salesforceAnnualReview !== null) {
            app(UpdateSalesforceAnnualReviewBySalesforceIdTask::class)->run(
                $objectId,
                new UpdateSalesforceAnnualReviewTransporter($this->convertData($info))
            );

            return;
        }

        app(CreateSalesforceAnnualReviewTask::class)->run(
            $account->member_id,
            $account->getKey(),
            new CreateSalesforceAnnualReviewTransporter($this->convertData($info)),
            $objectId
        );
    }

    private function convertData(array $info): array
    {
        return [
            'name'        => $info['Name'],
            'review_date' => isset($info['Annual_Review_Date__c']) ? Carbon::create($info['Annual_Review_Date__c']) : null,
            'amount'      => $info['Amount__c'] ?? null,
            'type'        => $info['Type__c'],
            'new_money'   => $info['Bringing_New_Money__c'],
            'notes'       => $info['Notes__c'],
        ];
    }
}
