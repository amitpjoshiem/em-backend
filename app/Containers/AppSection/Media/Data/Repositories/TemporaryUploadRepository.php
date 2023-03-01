<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

class TemporaryUploadRepository extends Repository
{
    /**
     * The container name. Must be set when the model has different name than the container.
     */
    protected string $container = 'Media';
}
