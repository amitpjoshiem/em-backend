<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\Tasks;

use App\Ship\Parents\Tasks\Task;
use DateTime;
use Exception;

/**
 * Class RenderTemplatesTask.
 */
class RenderTemplatesTask extends Task
{
    protected string $headerMarkdownContent;

    /**
     * @var string
     */
    public const TEMPLATE_PATH = 'Containers/Documentation/Stubs/';

    /**
     * @var string
     */
    public const OUTPUT_PATH = '../';

    /**
     * Read the markdown header template and fill it with some real data from the .env file.
     *
     * @throws Exception
     */
    public function run(): string
    {
        $content = file_get_contents(app_path(self::TEMPLATE_PATH . 'readme.template.md'));

        if (!\is_string($content)) {
            throw new Exception('readme.template.md file not found');
        }

        // read the template file
        $this->headerMarkdownContent = $content;

        $this->replace('api.domain.test', config('apiato.api.url'));
        $this->replace('{{rate-limit-expires}}', config('apiato.api.throttle.expires'));
        $this->replace('{{rate-limit-attempts}}', config('apiato.api.throttle.attempts'));
        $this->replace('{{access-token-expires-in}}', $this->minutesToTimeDisplay(config('apiato.api.expires-in')));
        $this->replace('{{access-token-expires-in-minutes}}', config('apiato.api.expires-in'));
        $this->replace('{{refresh-token-expires-in}}', $this->minutesToTimeDisplay(config('apiato.api.refresh-expires-in')));
        $this->replace('{{refresh-token-expires-in-minutes}}', config('apiato.api.refresh-expires-in'));
        $this->replace('{{pagination-limit}}', config('repository.pagination.limit'));

        // this is what the apidoc.json file will point to to load the README.md
        // example: "filename": "../README.md"
        $path = public_path(self::OUTPUT_PATH . 'README.md');

        // write the actual file
        file_put_contents($path, $this->headerMarkdownContent);

        return $path;
    }

    private function replace(string $templateKey, string | int $value): void
    {
        $this->headerMarkdownContent = str_replace($templateKey, (string)$value, $this->headerMarkdownContent);
    }

    private function minutesToTimeDisplay(int | string $minutes): string
    {
        $seconds = ((int)$minutes) * 60;

        $dtF = new DateTime('@0');
        $dtT = new DateTime(sprintf('@%s', $seconds));

        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }
}
