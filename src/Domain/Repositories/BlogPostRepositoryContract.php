<?php

namespace Domain\Repositories;

use Domain\Models\BlogPostContract;

interface BlogPostRepositoryContract
{
    public function all(): array;

    public function create(array $data): BlogPostContract;

    public function findOrFail(string $id): BlogPostContract;

    public function find(string $id): ?BlogPostContract;

    public function update(BlogPostContract $blogPost, array $data): BlogPostContract;

    public function delete(BlogPostContract $blogPost): bool;
}
