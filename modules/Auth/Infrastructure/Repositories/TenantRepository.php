<?php

namespace Modules\Auth\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Domain\Repositories\TenantRepositoryContract;
use Modules\Auth\Infrastructure\Models\Tenant;
use Throwable;

/**
 * This class encapsulates the logic required to access data sources.
 * It centralizes common data access functionality, providing better
 * maintainability and decoupling the infrastructure to access
 * databases from the domain model layer.
 */
class TenantRepository implements TenantRepositoryContract
{
    /**
     * Create a new instance of the class.
     *
     * @param TenantContract|Tenant $model
     */
    public function __construct(
        private readonly TenantContract $model,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return TenantContract
     * @throws Throwable
     */
    public function create(array $data): TenantContract
    {
        try {
            DB::beginTransaction();

            $tenant = $this->getNewQuery()->create($data);

            DB::commit();

            return $tenant;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param string $id
     * @return TenantContract
     */
    public function findOrFail(string $id): TenantContract
    {
        return $this->getNewQuery()->findOrFail($id);
    }

    /**
     * @param string $id
     * @return TenantContract|null
     */
    public function find(string $id): ?TenantContract
    {
        return $this->getNewQuery()->find($id);
    }

    /**
     * @param string $key
     * @return TenantContract|null
     */
    public function findByKey(string $key): ?TenantContract
    {
        return $this->getNewQuery()
            ->byKey($key)
            ->first();
    }

    /**
     * @param TenantContract $tenant
     * @param array<string, mixed> $data
     * @return TenantContract
     * @throws Throwable
     */
    public function update(TenantContract $tenant, array $data): TenantContract
    {
        try {
            DB::beginTransaction();

            $tenant->update($data);

            DB::commit();

            return $tenant;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param TenantContract $tenant
     * @return bool
     */
    public function delete(TenantContract $tenant): bool
    {
        return $tenant->delete() !== false;
    }

    /**
     * @return Builder|Tenant
     */
    private function getNewQuery(): Builder|Tenant
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return Tenant|TenantContract
     */
    private function getModel(): Tenant
    {
        return $this->model;
    }
}
