<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Tasks;

use App\Containers\AppSection\Telegram\Data\Enums\TelegramKeyboardEnum;
use App\Ship\Parents\Tasks\Task;
use Telegram\Bot\Keyboard\Keyboard;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class SendMainKeyboardTask extends Task
{
    public function run(TelegramBotUser $user): void
    {
        $keyboard = [];
        foreach (TelegramKeyboardEnum::values() as $button) {
            $keyboard[] = [Keyboard::button(['text' => $button])];
        }

        $user->service()->sendKeyboard($keyboard);
    }
}
