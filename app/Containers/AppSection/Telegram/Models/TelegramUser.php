<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\Models;

use App\Containers\AppSection\Telegram\Services\UserApiService;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zavrik\LaravelTelegram\Models\TelegramBot;

/**
 * @property User | null $user
 * @property TelegramBot $bot
 * @property int         $telegram_id
 */
class TelegramUser extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'bot_id',
        'telegram_id',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [

    ];

    /**
     * @var array<string>
     */
    protected $hidden = [

    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'TelegramUser';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class);
    }

    public function api(): UserApiService
    {
        return new UserApiService($this->bot, $this->telegram_id);
    }
}
