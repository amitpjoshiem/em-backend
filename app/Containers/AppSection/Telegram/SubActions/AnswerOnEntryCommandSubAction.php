<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\SubActions;

use App\Containers\AppSection\Telegram\Tasks\SendMainKeyboardTask;
use App\Ship\Parents\Actions\SubAction;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class AnswerOnEntryCommandSubAction extends SubAction
{
    /**
     * @throws \Exception
     */
    public function run(TelegramBotUser $telegramUser): void
    {
        if ($telegramUser->user === null) {
            $url = sprintf(
                '%s%s?bot_id=%s&telegram_id=%s',
                config('app.frontend_url'),
                config('appSection-telegram.front_login_url'),
                $telegramUser->bot->id,
                $telegramUser->telegram_id,
            );

            $telegramUser->service()->sendUrl('Please Login to IRIS Platform', $url);

            return;
        }

        $telegramUser->service()->sendMessage('You already subscribed on Alerts');
        app(SendMainKeyboardTask::class)->run($telegramUser);
    }
}
