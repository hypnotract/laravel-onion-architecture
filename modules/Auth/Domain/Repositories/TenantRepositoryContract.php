<?php

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Models\TenantContract;

interface TenantRepositoryContract
{
    public function create(array $data): TenantContract;

    public function findOrFail(string $id): TenantContract;

    public function find(string $id): ?TenantContract;

    public function findByKey(string $key): ?TenantContract;

    public function update(TenantContract $tenant, array $data): TenantContract;

    public function delete(TenantContract $tenant): bool;
}
