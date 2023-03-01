<?php

namespace Zavrik\LaravelTelegram\CLI;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Telegram\Bot\Api;
use Zavrik\LaravelTelegram\Models\TelegramBot;
use Zavrik\LaravelTelegram\Services\TelegramBotService;
use Zavrik\LaravelTelegram\Services\TelegramService;

class WebhookBotInfo extends Command
{
    protected $signature = 'telegram:bot:webhook:info {--name=}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->option('name');

        $bot = TelegramBot::getByName($name);

        var_dump($bot->api()->getWebhookInfo());
    }
}
