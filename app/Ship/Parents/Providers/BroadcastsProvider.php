<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\BroadcastsProvider as AbstractBroadcastsProvider;
use Illuminate\Support\Facades\Broadcast;
use function app_path;

/**
 * Class BroadcastsProvider.
 *
 * A.K.A app/Providers/BroadcastServiceProvider.php
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class BroadcastsProvider extends AbstractBroadcastsProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/Routes.php');
    }
}
