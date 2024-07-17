<?php

namespace Modules\Auth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Infrastructure\Models\Concerns\BelongsToTenant;
use Modules\Auth\Infrastructure\Models\Concerns\GeneratesUuid;

/**
 * This is a model class defined by a set of attributes representing the business data.
 * It also gives access to more advanced features, such as Active Record.
 */
class User extends Authenticatable implements UserContract
{
    use GeneratesUuid, BelongsToTenant, SoftDeletes;

    /**
     * @var array<array-key, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array<array-key, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where(compact('email'));
    }
}
