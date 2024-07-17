<?php

namespace Modules\Auth\Domain\Repositories;

use Modules\Auth\Domain\Models\UserContract;

interface UserRepositoryContract
{
    public function create(array $data): UserContract;

    public function findOrFail(string $id): UserContract;

    public function find(string $id): ?UserContract;

    public function findByEmail(string $email): ?UserContract;

    public function update(UserContract $user, array $data): UserContract;

    public function delete(UserContract $user): bool;
}
