<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Events\Events;

use App\Ship\Parents\Events\Event;

class AttachMediaToModelEvent extends Event
{
    public function __construct(
        public int $modelId,
        public string $modelType,
    ) {
    }
}
