<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class TableHasMaxRowsException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;

    /**
     * @var string
     */
    protected $message = 'This Table Has Max Allowable Rows';
}
