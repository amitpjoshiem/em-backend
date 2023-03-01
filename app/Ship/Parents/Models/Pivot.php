<?php

namespace App\Ship\Parents\Models;

use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Relations\Pivot as LaravelEloquentPivot;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

abstract class Pivot extends LaravelEloquentPivot
{
    use HashIdTrait;
    use HasRelationships;
    use HasResourceKeyTrait;
}
