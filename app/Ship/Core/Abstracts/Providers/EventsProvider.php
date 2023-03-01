<?php

namespace App\Ship\Core\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

abstract class EventsProvider extends LaravelEventServiceProvider
{
    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
