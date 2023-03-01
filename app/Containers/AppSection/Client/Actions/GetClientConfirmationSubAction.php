<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Actions;

use App\Containers\AppSection\Client\Data\Transporters\OutputClientConfirmationTransporter;
use App\Containers\AppSection\Client\Models\Client;
use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Containers\AppSection\Client\Tasks\GetClientConfirmationTask;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Database\Eloquent\Collection;

class GetClientConfirmationSubAction extends SubAction
{
    public function run(Client $client): OutputClientConfirmationTransporter
    {
        $client->refresh();
        /** @var Collection $confirmations */
        $confirmations = app(GetClientConfirmationTask::class)
            ->filterByClientId($client->getKey())
            ->run()
            ->groupBy('group');

        return new OutputClientConfirmationTransporter([
            'consultation'       => $client->consultation,
            'currently_have'     => $confirmations->get(ClientConfirmation::CURRENTLY_HAVE_GROUP) ?? new Collection(),
            'more_info_about'    => $confirmations->get(ClientConfirmation::MORE_INFO_ABOUT_GROUP) ?? new Collection(),
        ]);
    }
}
