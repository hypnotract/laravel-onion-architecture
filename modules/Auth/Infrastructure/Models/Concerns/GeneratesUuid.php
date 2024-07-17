<?php

namespace Modules\Auth\Infrastructure\Models\Concerns;

use Ramsey\Uuid\Uuid;

/**
 * This concern is meant for code reuse and is intended to reduce the limitations
 * of single inheritance and to separate the logic into distinct sections.
 */
trait GeneratesUuid
{
    /**
     * Generates and assigns a UUIDv1 to the model's primary key if it is not already set.
     *
     * @return void
     */
    protected static function bootUuids(): void
    {
        static::creating(static function ($model) {
            if (!empty($model->{$model->getKeyName()})) {
                return;
            }

            $model->{$model->getKeyName()} = Uuid::uuid1()->toString();
        });
    }

    /**
     * Returns the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Returns the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
