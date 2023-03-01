<?php

namespace App\Ship\Core\Abstracts\Transporters;

use App\Ship\Core\Abstracts\Requests\Request;
use App\Ship\Core\Traits\SanitizerTrait;
use Exception;
use ReflectionClass;
use ReflectionProperty;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\DataTransferObject as Dto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\DataTransferObject\Exceptions\ValidationException;
use Spatie\DataTransferObject\Reflection\DataTransferObjectClass;

abstract class Transporter extends Dto
{
    use SanitizerTrait;

    /**
     * Override the Dto constructor to extend it for supporting Requests objects as $input.
     * Transporter constructor.
     *
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(...$params)
    {
        /**
         * This way of parse arguments we take from \Spatie\DataTransferObject\DataTransferObject constructor.
         * See parent::_constructor(...$args).
         * And we need check if we have Request as $param need to take it from arguments.
         */
        if (is_array($params[0] ?? null) || ($params[0] ?? null) instanceof Request) {
            $params = $params[0];
        }
        /**
         * if the transporter got a Request object, get the content and headers
         * and pass them as array input to the Dto constructor.
         */
        if ($params instanceof Request) {
            $content = $params->toArray();
            $headers = [
                '_headers' => $params->headers->all(),
                'request'  => $params,
            ];

            $params = array_merge($headers, $content);
        }
        $invalidTypes = [];
        $class = new DataTransferObjectClass($this);

        foreach ($class->getProperties() as $property) {
            $fieldName = $property->name;
            $reflectionProperty = new ReflectionProperty($this, $property->name);

            /**
             * This step check is our $property has default value in final transporter or can be null
             * if no, and in input params we don`t have value for this $param throw an Error
             */
            if (
                ! isset($params[$fieldName])
                && ! $reflectionProperty->hasDefaultValue()
                && ! $reflectionProperty->getType()->allowsNull()
            ) {
                $invalidTypes[$fieldName][] = new Exception('Doesn\'t have default value');
                continue ;
            }

            /**
             * This step check Transporter Strict type.
             * If Transporter Strict we must set all values that can not be null.
             * For miss empty initialized params with null values we just skip their initialization.
             */
            if (
                ! array_key_exists($fieldName, $params)
                && $reflectionProperty->getType()->allowsNull()
                && ! $class->isStrict()
            ) {
                continue;
            }
            $property->setValue(Arr::get($params, $property->name) ?? $this->{$property->name} ?? null);

            $params = Arr::forget($params, $property->name);
        }

        if ($class->isStrict() && count($params)) {
            throw UnknownProperties::new(static::class, array_keys($params));
        }

        if (!empty($invalidTypes)) {
            throw new ValidationException($this, $invalidTypes);
        }

        $class->validate();
    }

    public function all(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        $properties = array_filter(
            $class->getProperties(ReflectionProperty::IS_PUBLIC),
            fn ($property) => $property->isInitialized($this)
        );

        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $mapToAttribute = $property->getAttributes(MapTo::class);
            $name = count($mapToAttribute) ? $mapToAttribute[0]->newInstance()->name : $property->getName();

            $data[$name] = $property->getValue($this);
        }

        return $data;
    }

    /**
     * This method mimics the $request->input() method but works on the "decoded" values.
     */
    public function getInputByKey(?string $key = null, mixed $default = null): mixed
    {
        return Arr::get($this->toArray(), $key, $default);
    }
}
