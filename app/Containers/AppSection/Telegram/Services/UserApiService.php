<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Services;

use Telegram\Bot\Laravel\Facades\Telegram;
use Zavrik\LaravelTelegram\Models\TelegramBot;

final class UserApiService
{
    public function __construct(protected TelegramBot $bot, protected int $telegramId)
    {
    }

    public function sendText(string $text): void
    {
        $this->bot->api()->sendMessage([
            'chat_id' => $this->telegramId,
            'text'    => $text,
        ]);
    }

    public function sendUrl(string $text, string $url): void
    {
        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
            ['0'],
        ];

        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard'          => $keyboard,
            'resize_keyboard'   => true,
            'one_time_keyboard' => true,
        ]);

        $this->bot->api()->sendMessage([
            'chat_id'      => $this->telegramId,
            'text'         => $text,
            'parse_mode'   => 'markdown',
            'reply_markup' => $replyMarkup,
        ]);
    }
}
