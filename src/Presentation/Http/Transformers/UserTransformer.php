<?php

namespace Presentation\Http\Transformers;

/**
 * This is the concrete implementation of a transformer representing the given model.
 * It transforms the provided list of fields that represent the response of that model.
 */
class UserTransformer extends BaseTransformer
{
    /**
     * @var array<string, string>
     */
    protected array $includes = [
        'posts' => BlogPostTransformer::class,
    ];

    /**
     * @var array<string, string>
     */
    protected array $fields = [
        'id' => 'string',
        'name' => 'string',
        'email' => 'string',
    ];
}
