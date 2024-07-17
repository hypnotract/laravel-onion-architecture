<?php

namespace Modules\Auth\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Domain\Models\TenantContract;
use Modules\Auth\Domain\Models\UserContract;
use Modules\Auth\Domain\Repositories\TenantRepositoryContract;
use Modules\Auth\Domain\Repositories\UserRepositoryContract;
use Modules\Auth\Domain\Services\TenantKeyServiceContract;
use Modules\Auth\Domain\Services\TenantManagerContract;
use Modules\Auth\Domain\Services\UserManagerContract;
use Modules\Auth\Infrastructure\Models\Tenant;
use Modules\Auth\Infrastructure\Models\User;
use Modules\Auth\Infrastructure\Repositories\TenantRepository;
use Modules\Auth\Infrastructure\Repositories\UserRepository;
use Modules\Auth\Infrastructure\Services\TenantKeyService;
use TenantManager;
use UserManager;

class AuthModuleServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public array $bindings = [
        // User
        UserContract::class => User::class,
        UserManagerContract::class => UserManager::class,
        UserRepositoryContract::class => UserRepository::class,
        // Tenant
        TenantContract::class => Tenant::class,
        TenantManagerContract::class => TenantManager::class,
        TenantRepositoryContract::class => TenantRepository::class,
        TenantKeyServiceContract::class => TenantKeyService::class,
    ];

    /**
     * @var array<mixed, string>
     */
    public array $singletons = [
        UserManagerContract::class,
        TenantManagerContract::class,
    ];
}
