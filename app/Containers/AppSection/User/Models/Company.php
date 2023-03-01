<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Models;

use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  * @OA\Schema (
 *     title="Company",
 *     description="Company data model",
 *     required={"id", "name", "domain"},
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="bpy390dg3jova6gm"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="Company Name"
 *     ),
 *     @OA\Property (
 *          property="domain",
 *          type="string",
 *          example="company.com"
 *     ),
 * )
 *
 * @property int        $id
 * @property string     $name
 * @property string     $domain
 * @property Collection $users
 */
class Company extends Model
{
    use SoftDeletes;

    protected static bool $useLogger = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'domain',
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
    protected string $resourceKey = 'Company';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
