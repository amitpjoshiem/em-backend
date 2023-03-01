<?php

declare(strict_types=1);

use Illuminate\Support\Arr;

if (!function_exists('loginAttributeValidationRulesMerger')) {
    function loginAttributeValidationRulesMerger(array $rules): array
    {
        $prefix                 = config('appSection-authentication.login.prefix', '');
        $allowedLoginAttributes = (array)config('appSection-authentication.login.attributes', ['email' => []]);

        if (count($allowedLoginAttributes) === 1) {
            $key                = array_key_first($allowedLoginAttributes);
            $optionalValidators = $allowedLoginAttributes[$key];
            $validators         = implode('|', $optionalValidators);

            $fieldName = $prefix . $key;

            $rules[$fieldName] = sprintf('required:%s|exists:users,%s|%s', $fieldName, $key, $validators);

            return $rules;
        }

        foreach ($allowedLoginAttributes as $key => $optionalValidators) {
            // build all other login fields together
            $otherLoginFields = Arr::except($allowedLoginAttributes, $key);
            $otherLoginFields = array_keys($otherLoginFields);
            $otherLoginFields = preg_filter('/^/', $prefix, $otherLoginFields);
            $otherLoginFields = implode(',', $otherLoginFields);

            $validators = implode('|', $optionalValidators);

            $fieldName = $prefix . $key;

            $rules[$fieldName] = sprintf('required_without_all:%s|exists:users,%s|%s', $otherLoginFields, $key, $validators);
        }

        return $rules;
    }
}
