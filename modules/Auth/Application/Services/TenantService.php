<?php

namespace Modules\Auth\Application\Services;

use Modules\Auth\Domain\Exceptions\TenantIsLiveException;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Domain\Repositories\TenantRepositoryContract;
use Modules\Auth\Domain\Services\TenantKeyServiceContract;

/**
 * This service class is defined by a set of public methods that apply the application logic.
 */
class TenantService
{
    /**
     * Create a new instance of the class.
     *
     * @param TenantRepositoryContract $tenantRepository
     * @param TenantKeyServiceContract $tenantKeyService
     */
    public function __construct(
        private readonly TenantRepositoryContract $tenantRepository,
        private readonly TenantKeyServiceContract $tenantKeyService,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return TenantContract
     */
    public function create(array $data): TenantContract
    {
        if (empty($data['key'])) {
            $data['key'] = $this->tenantKeyService->slugify($data['title']);
        }

        $data['isLive'] = false;

        return $this->tenantRepository->create($data);
    }

    /**
     * @param string $id
     * @return TenantContract
     */
    public function findOrFail(string $id): TenantContract
    {
        return $this->tenantRepository->findOrFail($id);
    }

    /**
     * @param string $id
     * @return TenantContract|null
     */
    public function find(string $id): ?TenantContract
    {
        return $this->tenantRepository->find($id);
    }

    /**
     * @param mixed|string|TenantContract $tenantOrId
     * @param array<string, mixed> $data
     * @return TenantContract
     */
    public function update(mixed $tenantOrId, array $data): TenantContract
    {
        $tenant = $tenantOrId instanceof TenantContract ? $tenantOrId : $this->findOrFail($tenantOrId);

        if ($tenant->isLive) {
            unset($data['key']);
        }

        return $this->tenantRepository->update($tenant, $data);
    }

    /**
     * @param mixed|string|TenantContract $tenantOrId
     * @return bool
     * @throws TenantIsLiveException
     */
    public function delete(mixed $tenantOrId): bool
    {
        $tenant = $tenantOrId instanceof TenantContract ? $tenantOrId : $this->find($tenantOrId);

        if ($tenant->isLive) {
            throw new TenantIsLiveException();
        }

        return $this->tenantRepository->delete($tenant);
    }
}
