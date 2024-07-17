<?php

namespace Modules\Auth\Domain\Exceptions;

use Exception;

class UninstantiatableUserException extends Exception
{
    /**
     * Create a new instance of the class.
     */
    public function __construct()
    {
        parent::__construct(
            'The given user could not be instantiated.',
            400,
        );
    }
}
