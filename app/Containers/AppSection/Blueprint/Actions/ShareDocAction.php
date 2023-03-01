<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Actions;

use App\Containers\AppSection\Blueprint\Data\Transporters\ShareBlueprintDocTransporter;
use App\Containers\AppSection\Blueprint\Events\Events\ShareDocEvent;
use App\Ship\Parents\Actions\Action;

class ShareDocAction extends Action
{
    public function run(ShareBlueprintDocTransporter $input): void
    {
        event(new ShareDocEvent($input->doc_id, $input->emails));
    }
}
