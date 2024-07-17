<?php

namespace Infrastructure\Models;

use Domain\Models\BlogPostContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Auth\Infrastructure\Models\User as BaseUser;

/**
 * This is a model class defined by a set of attributes representing the business data.
 * It also gives access to more advanced features, such as Active Record.
 *
 * @property Collection posts
 */
class User extends BaseUser
{
    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(app(BlogPostContract::class), 'author_id');
    }
}
