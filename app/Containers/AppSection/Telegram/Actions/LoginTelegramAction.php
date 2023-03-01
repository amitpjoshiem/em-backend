<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Actions;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Telegram\Data\Transporters\LoginTelegramTransporter;
use App\Containers\AppSection\Telegram\Tasks\SendMainKeyboardTask;
use App\Ship\Parents\Actions\Action;
use Exception;
use Zavrik\LaravelTelegram\Models\TelegramBot;

class LoginTelegramAction extends Action
{
    /**
     * @throws AuthenticationUserException
     * @throws Exception
     */
    public function run(LoginTelegramTransporter $data): void
    {
        $bot  = TelegramBot::getByName(config('appSection-telegram.telegram_bot_name'));
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($bot->getKey() !== $data->bot_id) {
            throw new Exception();
        }

        $telegramUser = $bot->service()->setUserIdToTelegramUser($data->telegram_id, $user->getKey());
        $telegramUser->service()->sendMessage('You Successfully logged in');
        app(SendMainKeyboardTask::class)->run($telegramUser);
    }
}
