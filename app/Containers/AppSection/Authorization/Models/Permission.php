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
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission.
 *
 * @property      int                             $id
 * @property      string                          $name
 * @property      string                          $guard_name
 * @property      string|null                     $display_name
 * @property      string|null                     $description
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|Permission[]         $permissions
 * @property-read int|null                        $permissions_count
 * @property-read Collection|Role[]               $roles
 * @property-read int|null                        $roles_count
 * @property-read Collection|User[]               $users
 * @property-read int|null                        $users_count
 *
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static Builder|Permission role($roles, $guard = null)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereDescription($value)
 * @method static Builder|Permission whereDisplayName($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Permission extends SpatiePermission
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
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];
}
