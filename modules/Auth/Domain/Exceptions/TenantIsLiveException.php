<?php

namespace Modules\Auth\Domain\Exceptions;

use Exception;

class TenantIsLiveException extends Exception
{
    /**
     * Create a new instance of the class.
     */
    public function __construct()
    {
        parent::__construct(
            'The desired manipulation cannot be performed because the given tenant is live.',
            400,
        );
    }
}
