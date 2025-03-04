<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Cuotas;
use App\Policies\CuotasPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Cuotas::class => CuotasPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}