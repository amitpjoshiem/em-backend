<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Events\Events;

use App\Ship\Parents\Events\Event;

class AttachMediaFromTemporaryUploadEvent extends Event
{
    public function __construct(
        public int $mediaId
    ) {
    }
}
