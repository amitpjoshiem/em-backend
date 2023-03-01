<?php

namespace App\Ship\Core\Abstracts\Models;

use App\Ship\Core\Traits\FactoryLocatorTrait;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelAuthenticatableUser;
use Spatie\Permission\Traits\HasRoles;

abstract class UserModel extends LaravelAuthenticatableUser
{
    use FactoryLocatorTrait, HasFactory {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
    use HashIdTrait;
    use HasResourceKeyTrait;
    use HasRoles;
}
