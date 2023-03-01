<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Models;

use App\Containers\AppSection\Media\Models\Media;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int   $id
 * @property int   $user_id
 * @property array $success_emails
 * @property array $error_emails
 * @property Media $file
 */
class MemberReport extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'success_emails',
        'error_emails',
        'file_id',
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
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'success_emails'    => 'array',
        'error_emails'      => 'array',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'MemberReports';

    public function file(): belongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
