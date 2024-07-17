<?php

namespace Modules\Auth\Infrastructure\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Domain\Services\TenantManagerContract;

/**
 * This concern is meant for code reuse and is intended to reduce the limitations
 * of single inheritance and to separate the logic into distinct sections.
 *
 * @property string tenant_id
 * @property TenantContract tenant
 */
trait BelongsToTenant
{
    /**
     * Assigns the current tenant ID to the model if it is
     * not already set and if a tenant is available.
     *
     * @return void
     */
    public static function bootBelongsToTenant(): void
    {
        static::creating(static function (self $model) {
            $tenantManager = app(TenantManagerContract::class);

            if ($model->tenant_id === null && $tenantManager->hasTenant()) {
                $model->tenant()->associate($tenantManager->getId());
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(
            app(TenantContract::class),
            $this->belongsToTenantForeignKey ?? null,
            $this->belongsToTenantLocalKey ?? null,
            $this->belongsToTenantRelation ?? null
        );
    }
}
