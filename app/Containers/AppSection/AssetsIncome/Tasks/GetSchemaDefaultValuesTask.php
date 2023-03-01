<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\Tasks;

use App\Ship\Parents\Tasks\Task;

class GetSchemaDefaultValuesTask extends Task
{
    public function run(bool $married): array
    {
        $data         = [];
        $schema       = config('appSection-assetsIncome.schema');
        /** @psalm-suppress PossibleRawObjectIteration */
        foreach ($schema['groups'] as $groupName => $rows) {
            foreach ($rows as $rowName => $elements) {
                if (!\is_array($elements)) {
                    if (!$elements::hasDefaultValue()) {
                        continue;
                    }

                    $data[$groupName][$rowName][$rowName] = $elements::DEFAULT_VALUE;
                    continue;
                }

                foreach ($elements as $elementName => $element) {
                    if (!$element::hasDefaultValue()) {
                        continue;
                    }

                    if ($elementName === 'spouse' && !$married) {
                        continue;
                    }

                    $data[$groupName][$rowName][$elementName] = $element::DEFAULT_VALUE;
                }
            }

            if (\in_array('spouse', $schema['headers'][$groupName], true) && !$married) {
                $pos = array_search('spouse', $schema['headers'][$groupName], true);
                unset($schema['headers'][$groupName][$pos]);
            }

            $data[$groupName]['total'] = array_fill_keys($schema['headers'][$groupName], 0);
        }

        return $data;
    }
}
