<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Models;

use App\Containers\AppSection\Otp\Services\OtpService;
use App\Ship\Parents\Models\Model;
use Illuminate\Support\Carbon;

/**
 * Class OtpSecurity.
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $secret
 * @property string      $service_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property OtpService  $otpService
 * @property bool        $enabled
 */
class OtpSecurity extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'secret',
        'service_type',
        'enabled',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'enabled'       => 'boolean',
        'service_type'  => 'object',
        'user_id'       => 'int',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'enabled' => true,
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'OtpSecurity';

    /**
     * Return OtpService.
     */
    public function getOtpServiceAttribute(): OtpService
    {
        /** @psalm-var class-string<OtpService> $service */
        $service = $this->service_type;

        return new $service();
    }
}
