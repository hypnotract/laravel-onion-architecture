<?php

namespace Modules\Auth\Domain\Services;

interface TenantKeyServiceContract
{
    public function slugify(?string $key): string;
}
