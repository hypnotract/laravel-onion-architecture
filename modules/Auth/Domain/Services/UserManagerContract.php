<?php

namespace Modules\Auth\Domain\Services;

use Modules\Auth\Domain\Models\UserContract;

interface UserManagerContract
{
    public function set(?UserContract $user): void;

    public function unset(): void;

    public function get(): ?UserContract;

    public function isCurrent(?UserContract $user): bool;
}
