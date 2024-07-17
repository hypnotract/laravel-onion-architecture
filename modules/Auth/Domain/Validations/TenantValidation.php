<?php

namespace Modules\Auth\Domain\Validations;

/**
 * This validation class is defined by a set of public methods that apply the business meaning.
 */
class TenantValidation
{
    /**
     * @return array<string, string>
     */
    public function getStoreRules(): array
    {
        return [
            'key' => 'string|max:55|unique',
            'title' => 'required|string|max:55|unique',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getUpdateRules(): array
    {
        return $this->getStoreRules();
    }
}
