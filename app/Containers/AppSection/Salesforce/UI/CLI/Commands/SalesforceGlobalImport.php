<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\CLI\Commands;

use App\Containers\AppSection\Salesforce\Actions\Account\Import\GlobalImportAccountAction;
use App\Containers\AppSection\Salesforce\Actions\AnnualReview\Import\GlobalImportAnnualReviewAction;
use App\Containers\AppSection\Salesforce\Actions\ChildOpportunity\Import\GlobalImportChildOpportunityAction;
use App\Containers\AppSection\Salesforce\Actions\Contact\Import\GlobalImportContactAction;
use App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface;
use App\Containers\AppSection\Salesforce\Actions\Opportunity\Import\GlobalImportOpportunityAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class SalesforceGlobalImport extends ConsoleCommand
{
    /**
     * @var array<class-string<\App\Containers\AppSection\Salesforce\Actions\GlobalImportObjectInterface>>
     */
    private const IMPORT_OBJECTS_ACTION = [
        GlobalImportAccountAction::class,
        GlobalImportContactAction::class,
        GlobalImportOpportunityAction::class,
        GlobalImportChildOpportunityAction::class,
        GlobalImportAnnualReviewAction::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:global:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    public function handle(): void
    {
        foreach (self::IMPORT_OBJECTS_ACTION as $object) {
            /** @var GlobalImportObjectInterface | null $action */
            $action = app($object);

            if ($action instanceof GlobalImportObjectInterface) {
                $action->run();
            }
        }
    }
}
