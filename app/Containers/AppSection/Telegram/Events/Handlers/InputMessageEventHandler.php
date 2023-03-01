<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Events\Handlers;

use App\Containers\AppSection\Telegram\Actions\AnswerTelegramAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Zavrik\LaravelTelegram\Events\InputMessageEvent;

class InputMessageEventHandler implements ShouldQueue
{
    public function handle(InputMessageEvent $event): void
    {
        if ($event->bot->name !== config('appSection-telegram.telegram_bot_name')) {
            return;
        }

        app(AnswerTelegramAction::class)->run($event->message);
    }
}
