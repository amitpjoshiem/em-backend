<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Models\SalesforceContact;
use App\Ship\Parents\Models\Model;

final class Contact extends AbstractObject
{
    public function __construct(public ?SalesforceContact $model)
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    private const OBJECT_NAME = 'Contact';

    public function getObjectName(): string
    {
        return self::OBJECT_NAME;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getCustomFields(): array
    {
        return [];
    }
}
