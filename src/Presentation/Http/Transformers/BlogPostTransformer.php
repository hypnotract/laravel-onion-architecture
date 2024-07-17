<?php

namespace Presentation\Http\Transformers;

/**
 * This is the concrete implementation of a transformer representing the given model.
 * It transforms the provided list of fields that represent the response of that model.
 */
class BlogPostTransformer extends BaseTransformer
{
    /**
     * @var array<string, string>
     */
    protected array $includes = [
        'author' => UserTransformer::class,
    ];

    /**
     * @var array<string, string>
     */
    protected array $fields = [
        'id' => 'string',
        'title' => 'string',
        'content' => 'string',
    ];
}
