<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\SubActions;

use App\Ship\Parents\Actions\SubAction;
use Illuminate\View\View;
use Zavrik\LaravelTelegram\Models\TelegramBot;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class SendAlertMessageSubAction extends SubAction
{
    public function run(View $view): void
    {
        $bot = TelegramBot::getByName(config('appSection-telegram.telegram_bot_name'));
        $bot->users->each(function (TelegramBotUser $user) use ($view): void {
            $user->service()->sendHtmlMessage($view->render());
        });
    }
}
