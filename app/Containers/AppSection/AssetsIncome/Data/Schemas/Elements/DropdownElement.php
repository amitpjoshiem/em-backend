<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\RowSchema;

final class DropdownElement extends BasicElement
{
    /**
     * @var string
     */
    public const TYPE = 'dropdown';

    protected array $options = [];

    public function __construct(public string $name, public RowSchema $row)
    {
        parent::__construct($name, $row);

        $optionsSchema = config('appSection-assetsIncome.schema.dropdown_options');
        foreach ($optionsSchema[$name] as $name => $label) {
            $this->options[] = ['label' => $label, 'name' => (string)$name];
        }
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
