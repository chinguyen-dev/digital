<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Color;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Policies\RolePolicy;
use App\Policies\ColorPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SliderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CustomerPolicy;
use Illuminate\Pagination\Paginator;
use App\Services\GateAndPoliceService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        Slider::class => SliderPolicy::class,
        Color::class => ColorPolicy::class,
        Category::class => ColorPolicy::class,
        Role::class => RolePolicy::class,
        Customer::class => CustomerPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $this->registerPolicies();

        new GateAndPoliceService();
    }
}
