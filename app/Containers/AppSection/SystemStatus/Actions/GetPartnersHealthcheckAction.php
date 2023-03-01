<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\Actions;

use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Containers\AppSection\SystemStatus\Data\Transporters\PartnersHealthcheckTransporter;
use App\Containers\AppSection\Yodlee\Services\YodleeAdminApiService;
use App\Ship\Parents\Actions\Action;
use Exception;

class GetPartnersHealthcheckAction extends Action
{
    public function __construct(
        protected SalesforceApiService $salesforceApiService,
        protected YodleeAdminApiService $yodleeAdminApiService
    ) {
    }

    public function run(): PartnersHealthcheckTransporter
    {
        $healthcheck = new PartnersHealthcheckTransporter();

        try {
            $this->salesforceApiService->ping()->status();
        } catch (Exception) {
            $healthcheck->salesforce = false;
        }

        try {
            $this->yodleeAdminApiService->status();
        } catch (Exception) {
            $healthcheck->yodlee = false;
        }

        try {
            /** @TODO After integrating HiddenLevers change to normal healthcheck */
            throw new Exception();
        } catch (Exception) {
            $healthcheck->hiddenlevers = false;
        }

        return $healthcheck;
    }
}
