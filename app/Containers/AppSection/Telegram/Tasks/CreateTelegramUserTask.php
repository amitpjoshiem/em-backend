<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Tasks;

use App\Containers\AppSection\Telegram\Data\Repositories\TelegramUserRepository;
use App\Containers\AppSection\Telegram\Models\TelegramUser;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Traits\TaskTraits\WithRelationsRepositoryTrait;

class CreateTelegramUserTask extends Task
{
    use WithRelationsRepositoryTrait;

    public function __construct(protected TelegramUserRepository $repository)
    {
    }

    public function run(int $telegramId, string $botId): TelegramUser
    {
        return $this->repository->create([
            'telegram_id' => $telegramId,
            'bot_id'      => $botId,
        ]);
    }
}
