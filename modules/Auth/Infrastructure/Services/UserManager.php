<?php


use Modules\Auth\Domain\Exceptions\UninstantiatableUserException;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Domain\Services\UserManagerContract;

/**
 * This class is a manager that can be applied whenever the system needs to support one or many entities of
 * a same or similar type. The Manager object is designed to keep track of all the entities.
 */
class UserManager implements UserManagerContract
{
    /**
     * @var UserContract|null
     */
    private ?UserContract $user = null;

    /**
     * Instantiates the given user if logged in.
     *
     * @param UserContract|null $user
     * @return void
     * @throws UninstantiatableUserException
     */
    public function set(?UserContract $user): void
    {
        if (!$user) {
            $this->user = null;

            return;
        }

        if ($this->isCurrent($user)) {
            return;
        }

        if (!$user->id) {
            throw new UninstantiatableUserException();
        }

        $this->user = $user;
    }

    /**
     * Unsets the user.
     *
     * @throws UninstantiatableUserException
     */
    public function unset(): void
    {
        $this->set(null);
    }

    /**
     * Returns the instantiated user or any field of it.
     *
     * @param string|null $field
     * @return mixed|UserContract|null
     */
    public function get(?string $field = null): mixed
    {
        return $field ? ($this->user->{$field} ?? null) : $this->user;
    }

    /**
     * Checks if there's an instantiated valid user.
     *
     * @return bool
     */
    public function hasUser(): bool
    {
        return $this->user && $this->user->id;
    }

    /**
     * Checks if the given user is the current one.
     *
     * @param string|UserContract $user
     * @return bool
     */
    public function isCurrent(mixed $user): bool
    {
        return $this->getId() === $user->id;
    }

    /**
     * Returns the id of the instantiated user.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->user?->id;
    }
}
