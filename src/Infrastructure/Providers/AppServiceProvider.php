<?php

namespace Infrastructure\Providers;

use Domain\Models\BlogPostContract;
use Domain\Repositories\BlogPostRepositoryContract;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Models\BlogPost;
use Infrastructure\Models\User;
use Infrastructure\Repositories\BlogPostRepository;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Infrastructure\Providers\AuthModuleServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array<array-key, string>
     */
    public array $providers = [
        AuthModuleServiceProvider::class,
    ];

    /**
     * @var array<string, string>
     */
    public array $bindings = [
        // User
        UserContract::class => User::class,
        // Blog
        BlogPostContract::class => BlogPost::class,
        BlogPostRepositoryContract::class => BlogPostRepository::class,
    ];
}
