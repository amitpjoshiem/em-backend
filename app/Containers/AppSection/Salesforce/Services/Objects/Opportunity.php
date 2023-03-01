<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Exceptions\SalesforceDescribeException;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Models\Model;
use JsonException;

final class Opportunity extends AbstractObject
{
    public function __construct(public ?SalesforceOpportunity $model)
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    private const OBJECT_NAME = 'Opportunity';

    /**
     * @var string
     */
    private const STAGE_LABEL = 'Stage';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }

    /**
     * @throws SalesforceDescribeException
     * @throws JsonException
     */
    public function getStageListValues(): array
    {
        return $this->getDescribeValuesByLabel(self::STAGE_LABEL);
    }

    public function findByAccountId(string $accountId): ?array
    {
        $query    = sprintf("SELECT FIELDS(ALL) FROM %s WHERE AccountId = '%s' LIMIT 200", $this->getObjectName(), $accountId);
        $response = $this->query($query);

        if ($response['totalSize'] === 0) {
            return null;
        }

        return $response['records'][0];
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getCustomFields(): array
    {
        return [
            'Master_Opportunity__c',
            'Date_of_1st__c',
            'Date_of_2nd__c',
            'Date_of_3rd__c',
            'X1st_Appt_Results__c',
            'X2nd_Appt_Results__c',
            'X3rd_Appt_Results__c',
            'X1st_Appointment_Status__c',
            'X2nd_Appointment_Status__c',
            'X3rd_Appointment_Status__c',
            'Total_Investment_Size__c',
        ];
    }
}
