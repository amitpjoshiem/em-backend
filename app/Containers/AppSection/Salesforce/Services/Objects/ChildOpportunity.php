<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters\SalesforceChildOpportunityTransporter;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceDescribeException;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Models\Model;
use JsonException;

final class ChildOpportunity extends AbstractObject
{
    public function __construct(private ?SalesforceChildOpportunity $model)
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    private const OBJECT_NAME = 'Child_Opportunity__c';

    /**
     * @var string
     */
    private const TYPE_LABEL = 'Type';

    /**
     * @var string
     */
    private const STAGE_LABEL = 'Child Opportunity Stage';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }

    /**
     * @throws NotFoundException
     * @throws UserNotFoundException
     */
    protected function getUpdatedObjectData(SalesforceChildOpportunityTransporter $input): array
    {
        return [
            'Client_Account__c'             => $input->accountId,
            'Opportunity_Amount__c'         => $input->amount,
            'Close_Date__c'                 => $input->close_date->format('Y-m-d'),
            'Name'                          => $input->name,
            'Child_Opportunity_Owner__c'    => $input->ownerId,
            'Child_Opportunity_Stage__c'    => $input->stage,
            'Type__c'                       => $input->type,
            'Primary_Campaign_Source__c'    => config('appSection-salesforce.campaign_id'),
        ];
    }

    /**
     * @throws SalesforceDescribeException
     * @throws JsonException
     */
    public function getTypeValues(): array
    {
        return $this->getDescribeValuesByLabel(self::TYPE_LABEL);
    }

    /**
     * @throws SalesforceDescribeException
     * @throws JsonException
     */
    public function getStageListValues(): array
    {
        return $this->getDescribeValuesByLabel(self::STAGE_LABEL);
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getCustomFields(): array
    {
        return [
            'Opportunity_Amount__c',
            'Child_Opportunity_Stage__c',
            'Type__c',
            'Close_Date__c',
            'Opportunity__c',
        ];
    }
}
