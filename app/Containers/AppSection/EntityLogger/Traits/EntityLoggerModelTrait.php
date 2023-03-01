<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\Traits;

use App\Containers\AppSection\EntityLogger\Models\EntityLog;
use App\Containers\AppSection\User\Traits\RealUserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Log;

trait EntityLoggerModelTrait
{
    use RealUserTrait;

    protected static bool $useLogger = true;

    public function logs(): MorphMany
    {
        return $this->morphMany(EntityLog::class, 'loggable');
    }

    protected static function boot(): void
    {
        parent::boot();

        if (static::$useLogger) {
            static::bootLogger();
        }
    }

    public static function bootLogger(): void
    {
        static::created(function ($model): void {
            $model->logCreated();
        });

        static::updating(function ($model): void {
            $model->logUpdated();
        });

        static::deleting(function ($model): void {
            $model->logDeleted($model);
        });
    }

    protected function insertNewLog($action, $before, $after): Model|bool
    {
        $user = $this->getRealUser();
        Log::info('user', ['user' => $user?->toArray()]);

        return $this->logs()->save(new EntityLog([
            'user_id'       => $user?->getKey(),
            'action'        => $action,
            'before'        => $before,
            'after'         => $after,
            'created_at'    => Carbon::now(),
        ]));
    }

    protected function logCreated(): Model|bool
    {
        $model = $this->stripRedundantKeys();

        return $this->insertNewLog('created', null, $model);
    }

    protected function logUpdated(): Model|bool
    {
        $diff = $this->getDiff();

        return $this->insertNewLog('updated', $diff['before'], $diff['after']);
    }

    protected function logDeleted(): Model|bool
    {
        $model = $this->stripRedundantKeys();

        return $this->insertNewLog('deleted', $model, null);
    }

    /**
     * Fetch a diff for the model's current state.
     */
    protected function getDiff(): array
    {
        $after = $this->getDirty();

        $before = array_intersect_key($this->fresh()->toArray(), $after);

        return ['before' => $before, 'after' => $after];
    }

    protected function stripRedundantKeys(): array
    {
        $model = $this->toArray();

        if (isset($model['created_at'])) {
            unset($model['created_at']);
        }

        if (isset($model['updated_at'])) {
            unset($model['updated_at']);
        }

        if (isset($model['id'])) {
            unset($model['id']);
        }

        return $model;
    }
}
