<?php


use Modules\Auth\Domain\Exceptions\UninstantiatableTenantException;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Domain\Repositories\TenantRepositoryContract;
use Modules\Auth\Domain\Services\TenantManagerContract;

/**
 * This class is a manager that can be applied whenever the system needs to support one or many entities of
 * a same or similar type. The Manager object is designed to keep track of all the entities.
 */
class TenantManager implements TenantManagerContract
{
    /**
     * @var TenantContract|null
     */
    private ?TenantContract $tenant = null;

    /**
     * Create a new instance of the class.
     *
     * @param TenantRepositoryContract $tenantRepository
     */
    public function __construct(
        private readonly TenantRepositoryContract $tenantRepository,
    ) {
    }

    /**
     * Instantiates the given tenant if it exists.
     *
     * @param string|TenantContract|null $tenant
     * @return void
     * @throws UninstantiatableTenantException
     */
    public function set(mixed $tenant): void
    {
        if (!$tenant) {
            $this->tenant = null;

            return;
        }

        if ($this->isCurrent($tenant)) {
            return;
        }

        $tenant = $this->solve($tenant);

        if (!$tenant) {
            throw new UninstantiatableTenantException();
        }

        $this->tenant = $tenant;
    }

    /**
     * Unsets the tenant.
     *
     * @throws UninstantiatableTenantException
     */
    public function unset(): void
    {
        $this->set(null);
    }

    /**
     * Returns the instantiated tenant or any field of it.
     *
     * @param string|null $field
     * @return mixed|TenantContract
     */
    public function get(?string $field = null): mixed
    {
        return $field ? ($this->tenant->{$field} ?? null) : $this->tenant;
    }

    /**
     * Checks if there's an instantiated valid tenant.
     *
     * @return bool
     */
    public function hasTenant(): bool
    {
        return (bool) $this->tenant?->id;
    }

    /**
     * Checks if the given tenant is the current one.
     *
     * @param string|TenantContract $tenant
     * @return bool
     */
    public function isCurrent(mixed $tenant): bool
    {
        $tenant = $this->solve($tenant);

        return $tenant && $this->getId() === $tenant->id;
    }

    /**
     * Returns the id of the instantiated tenant.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->tenant?->id;
    }

    /**
     * Returns the key of the instantiated tenant.
     *
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->tenant->key ?? null;
    }

    /**
     * @param string|TenantContract $tenant
     * @return TenantContract|null
     */
    private function solve(mixed $tenant): ?TenantContract
    {
        if (is_string($tenant)) {
            $tenant = $this->tenantRepository->findByKey($tenant);
        }

        $isValidTenant = $tenant instanceof TenantContract && $tenant->id;

        return $isValidTenant ? $tenant : null;
    }
}
