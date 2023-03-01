<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Handlers;

use App\Containers\AppSection\Media\Events\Events\AttachMediaToModelEvent;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetCacheAvatarKeyTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class AttachAvatarToUserEventHandler implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(AttachMediaToModelEvent $event): void
    {
        if ($event->modelType === User::class) {
            Cache::forget(app(GetCacheAvatarKeyTask::class)->run($event->modelId));
        }
    }

    public function failed(AttachMediaToModelEvent $event, Throwable $exception): void
    {
        Log::error(sprintf('Failed to forget cache Avatar Url. User Id: %s; Class : %s; Error message: %s', $event->modelId, $event->modelType, $exception->getMessage()));
    }
}
