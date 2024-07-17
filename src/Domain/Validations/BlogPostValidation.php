<?php

namespace Domain\Validations;

/**
 * This validation class is defined by a set of public methods that apply the business meaning.
 */
class BlogPostValidation
{
    /**
     * @return array<string, string>
     */
    public function getStoreRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getUpdateRules(): array
    {
        return [
            'title' => 'string|max:255',
            'content' => 'string',
        ];
    }
}
