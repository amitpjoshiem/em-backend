<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Containers\AppSection\Salesforce\Services\Objects\Account;
use App\Containers\AppSection\Salesforce\Services\Objects\AnnualReview;
use App\Containers\AppSection\Salesforce\Services\Objects\ChildOpportunity;
use App\Containers\AppSection\Salesforce\Services\Objects\Contact;
use App\Containers\AppSection\Salesforce\Services\Objects\Opportunity;
use App\Containers\AppSection\Salesforce\Services\Objects\Ping;
use App\Containers\AppSection\Salesforce\Services\Objects\User;

final class SalesforceApiService
{
    /**
     * @var string
     */
    public const ACCOUNT = 'account';

    /**
     * @var string
     */
    public const CONTACT = 'contact';

    /**
     * @var string
     */
    public const OPPORTUNITY = 'opportunity';

    /**
     * @var string
     */
    public const ANNUAL_REVIEW = 'annualReview';

    /**
     * @var string
     */
    public const CHILD_OPPORTUNITY = 'childOpportunity';

    public function account(?SalesforceAccount $account = null): Account
    {
        return  new Account($account);
    }

    public function contact(?SalesforceContact $contact = null): Contact
    {
        return new Contact($contact);
    }

    public function opportunity(?SalesforceOpportunity $opportunity = null): Opportunity
    {
        return new Opportunity($opportunity);
    }

    public function childOpportunity(?SalesforceChildOpportunity $childOpportunity = null): ChildOpportunity
    {
        return new ChildOpportunity($childOpportunity);
    }

    public function annualReview(?SalesforceAnnualReview $annualReview = null): AnnualReview
    {
        return new AnnualReview($annualReview);
    }

    public function user(): User
    {
        return new User();
    }

    public function ping(): Ping
    {
        return new Ping();
    }
}
