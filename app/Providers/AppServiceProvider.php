<?php

namespace App\Providers;

use App\Services\SharingService;
use App\Services\Impl\TagServiceImpl;
use App\Services\Impl\CartServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\Impl\ColorServiceImpl;
use App\Services\Impl\OrderServiceImpl;
use Illuminate\Support\ServiceProvider;
use App\Services\Impl\SliderServiceImpl;
use App\Services\Interfaces\ITagService;
use App\Services\Impl\ProductServiceImpl;
use App\Services\Interfaces\ICartService;
use App\Services\Interfaces\IRoleService;
use App\Services\Interfaces\IUserService;
use App\Services\Impl\CategoryServiceImpl;
use App\Services\Impl\CustomerServiceImpl;
use App\Services\Interfaces\IColorService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\ISliderService;
use App\Services\Impl\PermissionServiceImpl;
use App\Services\Impl\ProDisWardServiceImpl;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\ICustomerService;
use App\Services\Impl\ProductImageServiceImpl;
use App\Services\Interfaces\IPermissionService;
use App\Services\Interfaces\IProDisWardService;
use App\Services\Interfaces\IProductImageService;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Dependency Injection product
         */
        $this->app->singleton(IProductService::class, ProductServiceImpl::class);
        /**
         * Dependency Injection Slider
         */
        $this->app->singleton(ISliderService::class,  SliderServiceImpl::class);
        /**
         * Dependency Injection Category
         */
        $this->app->singleton(ICategoryService::class,  CategoryServiceImpl::class);

        /**
         * Dependency Injection Cart
         */
        $this->app->singleton(ICartService::class, CartServiceImpl::class);

        /**
         * Dependency Injection Province and District and Ward
         */
        $this->app->singleton(IProDisWardService::class, ProDisWardServiceImpl::class);

        /**
         * Dependency Injection Customer
         */
        $this->app->singleton(ICustomerService::class, CustomerServiceImpl::class);

        /**
         * Dependency Injection Order
         */
        $this->app->singleton(IOrderService::class, OrderServiceImpl::class);

        /**
         * Dependency Injection User
         */
        $this->app->singleton(IUserService::class, UserServiceImpl::class);

        /**
         * Dependency Injection Role
         */
        $this->app->singleton(IRoleService::class, RoleServiceImpl::class);

        /**
         * Dependency Injection Color
         */
        $this->app->singleton(IColorService::class, ColorServiceImpl::class);

        /**
         * Dependency Injection Permission
         */
        $this->app->singleton(IPermissionService::class, PermissionServiceImpl::class);

        /**
         * Dependency Injection Tag
         */
        $this->app->singleton(ITagService::class, TagServiceImpl::class);

        /**
         * Dependency Injection ProductImage
         */
        $this->app->singleton(IProductImageService::class, ProductImageServiceImpl::class);

        /**
         * Dependency Injection Share Data To Global Project
         */
        $this->app->singleton('shared', function () {
            $sharingService = new SharingService();
            $categories = $this->app->make(ICategoryService::class)->getAll();
            $sharingService->share('categories', $categories);
            return $sharingService;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
