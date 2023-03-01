<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Actions;

use App\Containers\AppSection\ClientReport\Data\Transporters\ShareClientReportDocTransporter;
use App\Containers\AppSection\ClientReport\Events\Events\ShareDocEvent;
use App\Ship\Parents\Actions\Action;

class ShareDocAction extends Action
{
    public function run(ShareClientReportDocTransporter $input): void
    {
        event(new ShareDocEvent($input->doc_id, $input->emails));
    }
}
