<?php

namespace Modules\Auth\Application\Services;

use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Domain\Repositories\UserRepositoryContract;

/**
 * This service class is defined by a set of public methods that apply the application logic.
 */
class UserService
{
    /**
     * Create a new instance of the class.
     *
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(
        private readonly UserRepositoryContract $userRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return UserContract
     */
    public function create(array $data): UserContract
    {
        return $this->userRepository->create($data);
    }

    /**
     * @param string $id
     * @return UserContract
     */
    public function findOrFail(string $id): UserContract
    {
        return $this->userRepository->findOrFail($id);
    }

    /**
     * @param string $id
     * @return UserContract|null
     */
    public function find(string $id): ?UserContract
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param mixed|string|UserContract $userOrId
     * @param array<string, mixed> $data
     * @return UserContract
     */
    public function update(mixed $userOrId, array $data): UserContract
    {
        $user = $userOrId instanceof UserContract ? $userOrId : $this->findOrFail($userOrId);

        return $this->userRepository->update($user, $data);
    }

    /**
     * @param mixed|string|UserContract $userOrId
     * @return bool
     */
    public function delete(mixed $userOrId): bool
    {
        $user = $userOrId instanceof UserContract ? $userOrId : $this->find($userOrId);

        return $this->userRepository->delete($user);
    }
}
