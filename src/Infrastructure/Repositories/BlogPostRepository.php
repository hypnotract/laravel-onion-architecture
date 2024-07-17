<?php

namespace Infrastructure\Repositories;

use Domain\Models\BlogPostContract;
use Domain\Repositories\BlogPostRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Infrastructure\Models\BlogPost;
use Throwable;

/**
 * This class encapsulates the logic required to access data sources.
 * It centralizes common data access functionality, providing better
 * maintainability and decoupling the infrastructure to access
 * databases from the domain model layer.
 */
class BlogPostRepository implements BlogPostRepositoryContract
{
    /**
     * @var Builder|null
     */
    protected ?Builder $query = null;

    /**
     * Create a new instance of the class.
     *
     * @param BlogPostContract $model
     */
    public function __construct(
        private readonly BlogPostContract $model,
    ) {
    }

    /**
     * @return array<array-key, BlogPost>
     */
    public function all(): array
    {
        return $this->getQuery()->all()->all();
    }

    /**
     * @param array<string, mixed> $data
     * @return BlogPostContract
     * @throws Throwable
     */
    public function create(array $data): BlogPostContract
    {
        try {
            DB::beginTransaction();

            $blogPost = $this->getNewQuery()->create($data);

            DB::commit();

            return $blogPost;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param string $id
     * @return BlogPostContract
     */
    public function findOrFail(string $id): BlogPostContract
    {
        return $this->getNewQuery()->findOrFail($id);
    }

    /**
     * @param string $id
     * @return BlogPostContract|null
     */
    public function find(string $id): ?BlogPostContract
    {
        return $this->getNewQuery()->find($id);
    }

    /**
     * @param BlogPostContract $blogPost
     * @param array<string, mixed> $data
     * @return BlogPostContract
     * @throws Throwable
     */
    public function update(BlogPostContract $blogPost, array $data): BlogPostContract
    {
        try {
            DB::beginTransaction();

            $blogPost->update($data);

            DB::commit();

            return $blogPost;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @param BlogPostContract $blogPost
     * @return bool
     */
    public function delete(BlogPostContract $blogPost): bool
    {
        return $blogPost->delete() !== false;
    }

    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->query = null;

        return $this;
    }

    /**
     * @return Builder|BlogPost
     */
    public function getQuery(): Builder|BlogPost
    {
        if ($this->query === null) {
            $this->query = $this->getNewQuery();
        }

        return $this->query;
    }

    /**
     * @return Builder|BlogPost
     */
    private function getNewQuery(): Builder|BlogPost
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return BlogPost
     */
    private function getModel(): BlogPost
    {
        return $this->model;
    }
}
