<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Data\Transporters\LoginAttributeTransporter;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Transporters\Transporter;

class ExtractLoginCustomAttributeTask extends Task
{
    public function run(Transporter $data): LoginAttributeTransporter
    {
        $prefix             = config('appSection-authentication.login.prefix', '');
        $allowedLoginFields = config('appSection-authentication.login.attributes') ?? ['email' => []];

        $fields = array_keys((array)$allowedLoginFields);

        $loginUsername = null;
        // The original attribute that which the user tried to log in witch
        // eg 'email', 'username', 'phone'
        $loginAttribute = null;

        // Find first login custom attribute (allowed login field) found in request
        // eg: search the request exactly in order which they are in 'appSection-authentication'
        // for 'email' then 'phone' then 'username' in request
        // and put the first one found in 'username' field witch its value as 'username' value
        foreach ($fields as $field) {
            $fieldName      = $prefix . $field;
            $loginUsername  = $data->getInputByKey($fieldName);
            $loginAttribute = $field;

            if ($loginUsername !== null) {
                break;
            }
        }

        return LoginAttributeTransporter::fromArrayable([
            'username'       => $loginUsername,
            'loginAttribute' => $loginAttribute,
        ]);
    }
}
