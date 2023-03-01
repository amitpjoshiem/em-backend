<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Contact;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Containers\AppSection\Member\Tasks\CreateMemberContactTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberContactTask;
use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\Contact\FindSalesforceContactBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\Contact\SaveSalesforceContactTask;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceTemporaryImportTask;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;

class SaveImportedContactSubAction extends SubAction implements SaveImportedObjectInterface
{
    public function run(array $info, string $objectId, ?int $userId = null): void
    {
        if ($info['AccountId'] === null) {
            return;
        }

        $salesforceAccount = app(FindSalesforceAccountBySalesforceIdTask::class)->run($info['AccountId']);

        if ($salesforceAccount === null) {
            app(CreateSalesforceTemporaryImportTask::class)->run(SalesforceApiService::CONTACT, $info['Id'], $info['OwnerId']);

            return;
        }

        $data = [
            'first_name'    => $info['FirstName'],
            'last_name'     => $info['LastName'],
            'birthday'      => $info['Birthdate'] !== null ? CarbonImmutable::create($info['Birthdate']) : null,
            'email'         => $info['Email'],
            'phone'         => $info['Phone'],
            'created_at'    => $info['CreatedDate'] !== null ? CarbonImmutable::create($info['CreatedDate']) : CarbonImmutable::now(),
            'updated_at'    => $info['LastModifiedDate'] !== null ? CarbonImmutable::create($info['LastModifiedDate']) : CarbonImmutable::now(),
        ];

        $salesforceContact = app(FindSalesforceContactBySalesforceIdTask::class)->run($objectId);

        if ($salesforceContact === null) {
            /** @var MemberContact $memberContact */
            $memberContact = app(CreateMemberContactTask::class)->run($salesforceAccount->member_id, $data);
            app(SaveSalesforceContactTask::class)->run($salesforceAccount->member_id, $memberContact->id, $objectId, $salesforceAccount->getKey());

            return;
        }

        app(UpdateMemberContactTask::class)->run($salesforceAccount->member_id, $data);
    }
}
