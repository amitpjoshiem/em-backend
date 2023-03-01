<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Models;

use App\Containers\AppSection\Salesforce\Services\SalesforceApiService;
use App\Ship\Parents\Models\Model;

/**
 * @property int    $id
 * @property string $name
 * @property array  $data
 */
class SalesforceInit extends Model
{
    protected static bool $useLogger = false;

    /**
     * @var string
     */
    public const STAGE_LIST = 'stage_list';

    /**
     * @var string
     */
    public const TYPE_LIST = 'type_list';

    /**
     * @var string
     */
    protected $table = 'salesforce_init';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'data',
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
        'data'    => 'array',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'SalesforceInit';

    public static function getStageList(): ?array
    {
        /** @var self | null $stageList */
        $stageList = self::where('name', '=', self::STAGE_LIST)->get()->first();

        return $stageList?->data;
    }

    public static function getTypeList(): ?array
    {
        /** @var self | null $stageList */
        $stageList = self::where('name', '=', self::TYPE_LIST)->get()->first();

        return $stageList?->data;
    }

    public static function sync(): void
    {
        $apiService = new SalesforceApiService();

        self::updateOrCreate([
            'name' => self::STAGE_LIST,
        ], [
            'data' => $apiService->childOpportunity()->getStageListValues(),
        ]);

        self::updateOrCreate([
            'name' => self::TYPE_LIST,
        ], [
            'data' => $apiService->childOpportunity()->getTypeValues(),
        ]);
    }
}
