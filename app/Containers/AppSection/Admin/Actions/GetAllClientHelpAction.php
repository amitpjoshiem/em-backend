<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\Actions;

use App\Containers\AppSection\Client\Data\Enums\ClientHelpPagesEnum;
use App\Containers\AppSection\Client\Data\Transporters\OutputClientHelpTransporter;
use App\Containers\AppSection\Client\Models\ClientHelp;
use App\Containers\AppSection\Client\Tasks\GetAllClientHelpTask;
use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Actions\SubAction;
use Illuminate\Support\Collection;

class GetAllClientHelpAction extends SubAction
{
    public function run(): array
    {
        /** @var Collection $clientHelp */
        $clientHelp = app(GetAllClientHelpTask::class)->withRelations(['media'])->run();

        $result = [];

        foreach (ClientHelpPagesEnum::values() as $type) {
            $result[$type] = new OutputClientHelpTransporter([
                'text'  => null,
                'media' => null,
                'type'  => $type,
            ]);
            /** @var ClientHelp | null $data */
            $data = $clientHelp->filter(fn (ClientHelp $help): bool => $help->type === $type)->first();

            if ($data !== null) {
                /** @var Media | null $media */
                $media = $data->media->first();

                $result[$type]->text  = $data->text;
                $result[$type]->media = $media;
            }
        }

        return $result;
    }
}
