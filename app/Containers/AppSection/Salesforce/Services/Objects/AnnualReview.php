<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Parents\Models\Model;

final class AnnualReview extends AbstractObject
{
    public function __construct(private ?SalesforceAnnualReview $model)
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    protected const OBJECT_NAME = 'Annual_Review__c';

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
            'Client_Account__c',
            'Annual_Review_Date__c',
            'Amount__c',
            'Type__c',
            'Bringing_New_Money__c',
            'Notes__c',
        ];
    }
}
