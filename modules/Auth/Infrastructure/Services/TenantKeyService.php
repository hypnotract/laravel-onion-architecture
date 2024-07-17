<?php

namespace Modules\Auth\Infrastructure\Services;

use Illuminate\Support\Str;
use Modules\Auth\Domain\Services\TenantKeyServiceContract;

/**
 * This service class is defined by a set of public methods that apply the business meaning.
 */
class TenantKeyService implements TenantKeyServiceContract
{
    /**
     * @param string|null $key
     * @return string
     */
    public function slugify(?string $key): string
    {
        if (!$key) {
            return uniqid('tenant_', true);
        }

        return Str::slug($key, '_');
    }
}
