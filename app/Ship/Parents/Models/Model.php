<?php

namespace App\Ship\Parents\Models;

use App\Containers\AppSection\EntityLogger\Traits\EntityLoggerModelTrait;
use App\Ship\Core\Abstracts\Models\Model as AbstractModel;
use App\Ship\Parents\Traits\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * Class Model.
 *
 * @mixin Builder
 * @property Collection $logs
 */
abstract class Model extends AbstractModel
{
    use EagerLoadPivotTrait;
    use HasRelationships;
    use EntityLoggerModelTrait;
}
