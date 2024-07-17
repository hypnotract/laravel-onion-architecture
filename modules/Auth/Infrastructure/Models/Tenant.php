<?php

namespace Modules\Auth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Infrastructure\Models\Concerns\GeneratesUuid;

/**
 * This is a model class defined by a set of attributes representing the business data.
 * It also gives access to more advanced features, such as Active Record.
 */
class Tenant extends EloquentModel implements TenantContract
{
    use GeneratesUuid, SoftDeletes;

    /**
     * @var array<array-key, string>
     */
    protected $fillable = [
        'key',
        'title',
    ];

    /**
     * @param Builder $query
     * @param string $key
     * @return Builder
     */
    public function scopeByKey(Builder $query, string $key): Builder
    {
        return $query->where(compact('key'));
    }
}
