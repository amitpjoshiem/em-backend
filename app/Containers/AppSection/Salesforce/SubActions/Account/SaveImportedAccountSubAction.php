<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\SubActions\Account;

use App\Containers\AppSection\Activity\Events\Events\ImportMemberFromSalesforceEvent;
use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tasks\CreateMemberTask;
use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Member\Tasks\UpdateMemberTask;
use App\Containers\AppSection\Notification\Events\Events\SalesforceImportAccountNotificationEvent;
use App\Containers\AppSection\Salesforce\Events\Events\CreateMemberFromSalesforceEvent;
use App\Containers\AppSection\Salesforce\Exceptions\FindSalesforceAccountException;
use App\Containers\AppSection\Salesforce\SubActions\SaveImportedObjectInterface;
use App\Containers\AppSection\Salesforce\Tasks\Account\FindSalesforceAccountBySalesforceIdTask;
use App\Containers\AppSection\Salesforce\Tasks\Account\SaveSalesforceAccountTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\SubAction;
use Carbon\CarbonImmutable;
use function app;
use function event;

class SaveImportedAccountSubAction extends SubAction implements SaveImportedObjectInterface
{
    /**
     * @throws FindSalesforceAccountException
     * @throws UpdateResourceFailedException
     * @throws CreateResourceFailedException
     */
    public function run(array $info, string $objectId, ?int $userId = null): void
    {
        if ($userId === null) {
            return;
        }

        $data             = $this->convertData($info, $userId);
        $salesforceMember = app(FindSalesforceAccountBySalesforceIdTask::class)->run($objectId);

        if ($salesforceMember !== null) {
            app(UpdateMemberTask::class)->run($salesforceMember->member_id, $data);
            app(SaveSalesforceAccountTask::class)->run($salesforceMember->member_id, $objectId, $this->convertAdditionalData($info));

            return;
        }

        $member = app(CreateMemberTask::class)->run($data);
        app(SaveSalesforceAccountTask::class)->run($member->getKey(), $objectId, $this->convertAdditionalData($info));
        event(new CreateMemberFromSalesforceEvent($member));
        event(new ImportMemberFromSalesforceEvent($userId, $member->getKey()));
        event(new SalesforceImportAccountNotificationEvent($member->getKey(), $userId));
    }

    private function convertData(array $info, int $userId): array
    {
        /** @var CarbonImmutable $cratedAt */
        $cratedAt = $info['CreatedDate'] !== null ? CarbonImmutable::create($info['CreatedDate']) : CarbonImmutable::now();
        /** @var CarbonImmutable $updatedAt */
        $updatedAt = $info['LastModifiedDate'] !== null ? CarbonImmutable::create($info['LastModifiedDate']) : CarbonImmutable::now();
        $account   = app(FindSalesforceAccountBySalesforceIdTask::class)->run($info['Id']);
        $member    = null;
        $type      = $info['Type'] === null ? Member::PROSPECT : strtolower($info['Type']);

        if ($account !== null) {
            $member = app(FindMemberByIdTask::class)->run($account->member_id);
            $type   = $member->type;
        }

        return [
            'created_at'      => $cratedAt->timestamp,
            'updated_at'      => $updatedAt->timestamp,
            'type'            => $type,
            'retired'         => $member?->retired ?? false,
            'married'         => $member?->married ?? false,
            'name'            => $info['Name'],
            'email'           => $info['Client_Email_Primary__c'],
            'phone'           => $info['Phone'],
            'retirement_date' => $member?->retirement_date ?? null,
            'address'         => $info['BillingStreet'],
            'city'            => $info['BillingCity'],
            'state'           => $info['BillingState'],
            'zip'             => $info['BillingPostalCode'],
            'user_id'         => $userId,
            'step'            => $member?->step ?? MemberStepsEnum::DEFAULT,
        ];
    }

    private function convertAdditionalData(array $info): array
    {
        return [
            'do_not_mail'           => $info['Do_Not_Mail__c'] ?? null,
            'category'              => $info['Category__c'] ?? null,
            'client_start_date'     => $info['Client_Start_Date__c'] ?? null,
            'client_ar_date'        => $info['Client_AR_Date__c'] ?? null,
            'p_c_client'            => $info['P_C_Client__c'] ?? null,
            'tax_conversion_client' => $info['Tax_Conversion_Client__c'] ?? null,
            'platinum_club_client'  => $info['Platinum_Club_Client__c'] ?? null,
            'medicare_client'       => $info['Medicare_Client__c'] ?? null,
            'household_value'       => $info['Household_Value__c'] ?? null,
            'total_investment_size' => $info['Total_Investment_Size__c'] ?? null,
            'political_stance'      => $info['Political_Stance__c'] ?? null,
            'client_average_age'    => $info['Client_Average_Age__c'] ?? null,
            'primary_contact'       => $info['Primary_Contact__c'] ?? null,
            'military_veteran'      => $info['Military_Veteran__c'] ?? null,
            'homework_completed'    => $info['Homework_Completed__c'] ?? null,
        ];
    }
}
