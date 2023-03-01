<?php

namespace App\Ship\Core\Abstracts\Models;

use App\Ship\Core\Traits\FactoryLocatorTrait;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;

abstract class Model extends LaravelEloquentModel
{
    use FactoryLocatorTrait, HasFactory {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
    use HashIdTrait;
    use HasResourceKeyTrait;
}
