<?php

namespace Modules\Auth\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Domain\Repositories\UserRepositoryContract;
use Modules\Auth\Infrastructure\Models\User;
use Throwable;

/**
 * This class encapsulates the logic required to access data sources.
 * It centralizes common data access functionality, providing better
 * maintainability and decoupling the infrastructure to access
 * databases from the domain model layer.
 */
class UserRepository implements UserRepositoryContract
{
    /**
     * Create a new instance of the class.
     *
     * @param UserContract|User $model
     */
    public function __construct(
        private readonly UserContract $model,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return UserContract
     * @throws Throwable
     */
    public function create(array $data): UserContract
    {
        try {
            DB::beginTransaction();

            $user = $this->getNewQuery()->create($data);

            DB::commit();

            return $user;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param string $id
     * @return UserContract
     */
    public function findOrFail(string $id): UserContract
    {
        return $this->getNewQuery()->findOrFail($id);
    }

    /**
     * @param string $id
     * @return UserContract|null
     */
    public function find(string $id): ?UserContract
    {
        return $this->getNewQuery()->find($id);
    }

    /**
     * @param string $email
     * @return UserContract|null
     */
    public function findByEmail(string $email): ?UserContract
    {
        return $this->getNewQuery()
            ->byEmail($email)
            ->first();
    }

    /**
     * @param UserContract $user
     * @param array<string, mixed> $data
     * @return UserContract
     * @throws Throwable
     */
    public function update(UserContract $user, array $data): UserContract
    {
        try {
            DB::beginTransaction();

            $user->update($data);

            DB::commit();

            return $user;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param UserContract $user
     * @return bool
     */
    public function delete(UserContract $user): bool
    {
        return $user->delete() !== false;
    }

    /**
     * @return Builder|User
     */
    private function getNewQuery(): Builder|User
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return User|UserContract
     */
    private function getModel(): User
    {
        return $this->model;
    }
}
