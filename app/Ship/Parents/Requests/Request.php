<?php

namespace App\Ship\Parents\Requests;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Ship\Core\Abstracts\Exceptions\Exception;
use App\Ship\Core\Abstracts\Requests\Request as AbstractRequest;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Ship\Exceptions\NotFoundException;
use http\Exception\BadUrlException;
use Illuminate\Contracts\Queue\EntityNotFoundException;

abstract class Request extends AbstractRequest
{
    /**
     * Check if the submitted ID (mainly URL ID's) is the same as
     * the authenticated user ID (based on the user Token).
     */
    public function isOwner(): bool
    {
        return !empty($this->id) && app(GetAuthenticatedUserTask::class)->run()->id === $this->id;
    }

    /**
     * @throws NotFoundException
     */
    public function getIdFromRoute(): int
    {
        $encodeId = $this->route('id');

        if ($encodeId === null || !is_string($encodeId)) {
            throw new NotFoundException();
        }

        $id = $this->decode($encodeId);

        if (!is_int($id)) {
            throw new NotFoundException();
        }

        return $id;
    }
}
