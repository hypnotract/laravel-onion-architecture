<?php

namespace Modules\Auth\Domain\Validations;

/**
 * This validation class is defined by a set of public methods that apply the business meaning.
 */
class UserValidation
{
    /**
     * @return array<string, string>
     */
    public function getStoreRules(): array
    {
        return [
            'name' => 'required|string|max:55',
            'email' => 'required|email|max:255|unique',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getUpdateRules(): array
    {
        return [
            ...$this->getStoreRules(),
            'email' => 'missing',
        ];
    }
}
