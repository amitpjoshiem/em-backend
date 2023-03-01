<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\EventsProvider as AbstractEventsProvider;

/**
 * Class EventsProvider.
 *
 * A.K.A app/Providers/EventsServiceProvider.php
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class EventsProvider extends AbstractEventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
