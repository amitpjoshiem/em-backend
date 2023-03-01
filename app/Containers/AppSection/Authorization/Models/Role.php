<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Models;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Core\Traits\FactoryLocatorTrait;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 *
 * @OA\Schema (
 *     title="Role",
 *     description="Role model",
 *     @OA\Property (
 *          property="id",
 *          type="string",
 *          example="bpy390dg3jova6gm"
 *     ),
 *     @OA\Property (
 *          property="name",
 *          type="string",
 *          example="test"
 *     ),
 *     @OA\Property (
 *          property="guard_name",
 *          type="string",
 *          example="web"
 *     ),
 *     @OA\Property (
 *          property="display_name",
 *          type="string",
 *          example="Test Role"
 *     ),
 *     @OA\Property (
 *          property="description",
 *          type="string",
 *          example="Test Description"
 *     ),
 *     @OA\Property (
 *          property="level",
 *          type="int",
 *          example="100"
 *     ),
 * )
 *
 * @property      int                             $id
 * @property      string                          $name
 * @property      string                          $guard_name
 * @property      string|null                     $display_name
 * @property      string|null                     $description
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property      int                             $level
 * @property-read Collection|Permission[]         $permissions
 * @property-read int|null                        $permissions_count
 * @property-read Collection|User[]               $users
 * @property-read int|null                        $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereLevel($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends SpatieRole
{
    use FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;

    }
    use HasFactory;
    use HashIdTrait;
    use HasResourceKeyTrait;

    protected static bool $useLogger = false;

    protected string $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'level',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'level' => 'integer',
    ];
}
