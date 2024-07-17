<?php

namespace Application\Services;

use Domain\Models\BlogPostContract;
use Domain\Repositories\BlogPostRepositoryContract;

/**
 * This service class is defined by a set of public methods that apply the application logic.
 */
class BlogPostService
{
    /**
     * Create a new instance of the class.
     *
     * @param BlogPostRepositoryContract $blogPostRepository
     */
    public function __construct(
        private readonly BlogPostRepositoryContract $blogPostRepository,
    ) {
    }

    /**
     * @return array<array-key, BlogPostContract>
     */
    public function index(): array
    {
        $this->blogPostRepository->getQuery()->where('posted_at', '<=', now());

        return $this->blogPostRepository->all();
    }

    /**
     * @param array<string, mixed> $data
     * @return BlogPostContract
     */
    public function create(array $data): BlogPostContract
    {
        return $this->blogPostRepository->create($data);
    }

    /**
     * @param string $id
     * @return BlogPostContract
     */
    public function findOrFail(string $id): BlogPostContract
    {
        return $this->blogPostRepository->findOrFail($id);
    }

    /**
     * @param string $id
     * @return BlogPostContract|null
     */
    public function find(string $id): ?BlogPostContract
    {
        return $this->blogPostRepository->find($id);
    }

    /**
     * @param mixed|string|BlogPostContract $blogPostOrId
     * @param array<string, mixed> $data
     * @return BlogPostContract
     */
    public function update(mixed $blogPostOrId, array $data): BlogPostContract
    {
        $blogPost = $blogPostOrId instanceof BlogPostContract ? $blogPostOrId : $this->findOrFail($blogPostOrId);

        return $this->blogPostRepository->update($blogPost, $data);
    }

    /**
     * @param mixed|string|BlogPostContract $blogPostOrId
     * @return bool
     */
    public function delete(mixed $blogPostOrId): bool
    {
        $blogPost = $blogPostOrId instanceof BlogPostContract ? $blogPostOrId : $this->find($blogPostOrId);

        return $this->blogPostRepository->delete($blogPost);
    }
}
