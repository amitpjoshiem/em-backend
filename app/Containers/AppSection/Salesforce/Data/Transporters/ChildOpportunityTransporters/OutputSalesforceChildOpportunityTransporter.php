<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters\ChildOpportunityTransporters;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Transporters\Transporter;

class OutputSalesforceChildOpportunityTransporter extends Transporter
{
    public string $id;

    public string $Name;

    public ?string $Type__c;

    public ?string $Child_Opportunity_Stage__c;

    public ?string $Close_Date__c;

    public ?float $Opportunity_Amount__c;

    public ?string $CreatedDate;

    public ?User $owner;
}
