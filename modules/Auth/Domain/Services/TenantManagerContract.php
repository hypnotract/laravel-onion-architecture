<?php

namespace Modules\Auth\Domain\Services;

use Modules\Auth\Domain\Models\TenantContract;

interface TenantManagerContract
{
    public function set(mixed $tenant): void;

    public function unset(): void;

    public function get(): ?TenantContract;

    public function isCurrent(mixed $tenant): bool;

    public function solve(mixed $tenant): ?TenantContract;
}
