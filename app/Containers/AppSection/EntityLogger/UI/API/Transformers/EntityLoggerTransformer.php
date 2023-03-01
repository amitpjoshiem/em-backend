<?php

declare(strict_types=1);

namespace App\Containers\AppSection\EntityLogger\UI\API\Transformers;

use App\Containers\AppSection\EntityLogger\Models\BelongToMemberInterface;
use App\Containers\AppSection\EntityLogger\Models\EntityLog;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Models\Model;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Str;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

class EntityLoggerTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(EntityLog $entityLog): array
    {
        /**
         * @var Model $entity
         * @psalm-suppress InvalidStringClass
         */
        $entity = new $entityLog->loggable_type();

        if ($entity instanceof BelongToMemberInterface) {
            $entity = $entity->with(['member'])->find($entityLog->loggable_id);
            $member = $entity->member;
        } elseif ($entity instanceof Member) {
            $entity = $entity->find($entityLog->loggable_id);
            $member = $entity;
        } else {
            $member = null;
        }

        return [
            'date'        => $entityLog->created_at->toDateString(),
            'time'        => $entityLog->created_at->toTimeString(),
            'action'      => $entityLog->action,
            'entity'      => trim(preg_replace('#(?<!\ )[A-Z]#', ' $0', $entity->getResourceKey())),
            'member_id'   => $member?->getHashedKey(),
            'client_id'   => $member?->client?->getHashedKey(),
            'member_name' => $member?->name,
            'member_type' => $member?->type,
            'changes'     => $this->formatChanges($entityLog->before, $entityLog->after),
        ];
    }

    public function includeUser(EntityLog $entityLog): NullResource | Item
    {
        if ($entityLog->user !== null) {
            return $this->item($entityLog->user, new UserTransformer());
        }

        return $this->null();
    }

    public function formatChanges(?array $before, ?array $after): array
    {
        $changes = [];

        if ($after !== null) {
            foreach ($after as $field => $value) {
                if (str_ends_with($field, '_id')) {
                    continue;
                }

                if (isset($before[$field])) {
                    $changes[$field] = sprintf('%s: %s -> %s', $this->formatStringField($field), $before[$field], $value ?? '-');
                } else {
                    $changes[$field] = sprintf('%s: %s', $this->formatStringField($field), $value ?? '-');
                }
            }
        }

        return array_values($changes);
    }

    private function formatStringField(string $field): string
    {
        return Str::replace('_', ' ', Str::title($field));
    }
}
