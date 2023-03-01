<?php

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\UserModel as AbstractUserModel;
use App\Ship\Parents\Traits\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * Class UserModel.
 *
 * @mixin Builder
 */
abstract class UserModel extends AbstractUserModel
{
    use EagerLoadPivotTrait;
    use HasApiTokens;
    use HasRelationships;
    use Notifiable;
    use SoftDeletes;
}
