<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Admin\Data\Transporters\EditClientVideoPageTransporter;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Containers\AppSection\Client\Tasks\GetClientHelpTask;
use App\Ship\Parents\Actions\SubAction;

class GetClientHelpAction extends SubAction
{
    public function run(EditClientVideoPageTransporter $data): array
    {
        /** @var ClientHelp | null $clientHelp */
        $clientHelp = app(GetClientHelpTask::class)->withRelations(['media'])->run($data->type);

        return [
            'type'  => $data->type,
            'text'  => $clientHelp?->text,
            'media' => $clientHelp?->media,
        ];
    }
}
