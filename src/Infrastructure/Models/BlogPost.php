<?php

namespace Infrastructure\Models;

use Domain\Models\BlogPostContract;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Infrastructure\Models\Concerns\BelongsToTenant;
use Modules\Auth\Infrastructure\Models\Concerns\GeneratesUuid;

/**
 * This is a model class defined by a set of attributes representing the business data.
 * It also gives access to more advanced features, such as Active Record.
 *
 * @property User author
 */
class BlogPost extends EloquentModel implements BlogPostContract
{
    use GeneratesUuid, BelongsToTenant;

    /**
     * @var array<array-key, string>
     */
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'posted_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(app(UserContract::class), 'author_id');
    }
}
