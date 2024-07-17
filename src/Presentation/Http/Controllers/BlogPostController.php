<?php

namespace Presentation\Http\Controllers;

use Application\Services\BlogPostService;
use Illuminate\Http\Response;
use Infrastructure\Models\BlogPost;
use Presentation\Http\Requests\BlogPostStoreRequest;
use Presentation\Http\Requests\BlogPostUpdateRequest;
use Presentation\Http\Transformers\BlogPostTransformer;

class BlogPostController extends BaseController
{
    /**
     * Create a new instance of the class.
     *
     * @param BlogPostService $service
     * @param BlogPostTransformer $transformer
     */
    public function __construct(
        private readonly BlogPostService $service,
        private readonly BlogPostTransformer $transformer
    ) {
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->response->collection($this->service->index(), $this->transformer);
    }

    /**
     * @param BlogPost $blogPost
     * @return Response
     */
    public function show(BlogPost $blogPost): Response
    {
        return $this->response->item($blogPost, $this->transformer);
    }

    /**
     * @param BlogPostStoreRequest $request
     * @return Response
     */
    public function store(BlogPostStoreRequest $request): Response
    {
        return $this->response->item(
            $this->service->create($request->validated()),
            $this->transformer
        );
    }

    /**
     * @param BlogPostUpdateRequest $request
     * @param BlogPost $blogPost
     * @return Response
     */
    public function update(BlogPostUpdateRequest $request, BlogPost $blogPost): Response
    {
        return $this->response->item(
            $this->service->update($blogPost, $request->validated()),
            $this->transformer
        );
    }
}
