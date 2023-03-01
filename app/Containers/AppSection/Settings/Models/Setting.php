<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\Models;

use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Traits\EagerLoadPivotBuilder;
use Barryvdh\LaravelIdeHelper\Eloquent;

/**
 * Class Setting.
 *
 * @property int    $id
 * @property string $key
 * @property string $value
 *
 * @method static EagerLoadPivotBuilder|Setting newModelQuery()
 * @method static EagerLoadPivotBuilder|Setting newQuery()
 * @method static EagerLoadPivotBuilder|Setting query()
 * @method static EagerLoadPivotBuilder|Setting whereId($value)
 * @method static EagerLoadPivotBuilder|Setting whereKey($value)
 * @method static EagerLoadPivotBuilder|Setting whereValue($value)
 * @mixin Eloquent
 */
class Setting extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}
