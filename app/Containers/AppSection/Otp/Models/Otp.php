<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Models;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Token;

/**
 * Class Otp.
 *
 * @property int                                         $id
 * @property string                                      $external_token
 * @property int                                         $user_id
 * @property int                                         $oauth_access_token_id
 * @property bool                                        $revoked
 * @property \Illuminate\Support\Carbon|null             $created_at
 * @property \Illuminate\Support\Carbon|null             $updated_at
 * @property \Illuminate\Support\Carbon                  $expires_at
 * @property \App\Containers\AppSection\User\Models\User $user
 * @property AccessToken                                 $accessToken
 */
class Otp extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'external_token',
        'user_id',
        'oauth_access_token_id',
        'revoked',
        'expires_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked'    => 'bool',
        'user_id'    => 'int',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Otp';

    public function isOtpExpired(): bool
    {
        return $this->expires_at->diffInSeconds(Carbon::now()) <= 0;
    }

    public function isOtpRevoked(): bool
    {
        return $this->revoked;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessToken(): BelongsTo
    {
        return $this->belongsTo(Token::class);
    }
}
