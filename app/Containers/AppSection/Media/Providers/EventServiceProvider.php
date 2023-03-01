<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Providers;

use App\Containers\AppSection\Media\Events\Handlers\ProcessUploadedMedia;
use App\Ship\Parents\Providers\EventsProvider;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MediaHasBeenAdded::class => [
            ProcessUploadedMedia::class,
        ],
    ];
}
