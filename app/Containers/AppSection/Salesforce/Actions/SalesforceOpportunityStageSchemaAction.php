<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Actions;

use App\Containers\AppSection\Salesforce\Data\Transporters\SalesforceOpportunityStageSchemaTransporter;
use App\Ship\Parents\Actions\Action;

class SalesforceOpportunityStageSchemaAction extends Action
{
    public function run(SalesforceOpportunityStageSchemaTransporter $input): array
    {
        /** @var array | null $schema */
        $schema = config(sprintf('appSection-salesforce.opportunity_stage_schema.%s', $input->stage));

        if ($schema === null) {
            return [
                'schema' => [],
                'rules'  => [],
            ];
        }

        $rules = [];

        foreach ($schema as $name => &$field) {
            $fieldRules            = $field['rules'];
            $fieldRules['type']    = $field['type'];
            $fieldRules['trigger'] = match ($field['type']) {
                'select', 'date' => 'change',
                'input' => 'blur',
            };
            $rules[$name][] = $fieldRules;
            unset($field['rules']);
        }

        return [
            'schema' => array_values($schema),
            'rules'  => $rules,
        ];
    }
}
