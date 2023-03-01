<?php

namespace App\Ship\Parents\Policies;

use App\Ship\Core\Abstracts\Policies\Policy as AbstractPolicy;
use Illuminate\Auth\Access\Response;

abstract class Policy extends AbstractPolicy
{
    /**
     * Create a new access response.
     *
     * @param  string|null  $message
     * @param  mixed  $code
     * @return \Illuminate\Auth\Access\Response
     */
    protected function allow($message = null, $code = null)
    {
        return Response::allow($message, $code);
    }

    /**
     * Throws an unauthorized exception.
     *
     * @param  string|null  $message
     * @param  mixed|null  $code
     * @return \Illuminate\Auth\Access\Response
     */
    protected function deny($message = null, $code = null)
    {
        return Response::deny($message, $code);
    }
}
