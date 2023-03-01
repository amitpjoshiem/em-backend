<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Ship\Parents\Models\Model;

final class Account extends AbstractObject
{
    public function __construct(private ?SalesforceAccount $model)
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    protected const OBJECT_NAME = 'Account';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getCustomFields(): array
    {
        return [
            'Client_Email_Primary__c',
            'Do_Not_Mail__c',
            'Category__c',
            'Client_Start_Date__c',
            'Client_AR_Date__c',
            'P_C_Client__c',
            'Tax_Conversion_Client__c',
            'Platinum_Club_Client__c',
            'Medicare_Client__c',
            'Household_Value__c',
            'Total_Investment_Size__c',
            'Political_Stance__c',
            'Client_Average_Age__c',
            'Primary_Contact__c',
            'Military_Veteran__c',
            'Homework_Completed__c',
        ];
    }
}
