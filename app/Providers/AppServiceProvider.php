<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ContractAmendment;
use App\Observers\ContractAmendmentObserver;
use App\Models\Asset;
use App\Observers\AssetObserver;
use App\Models\Contract;
use App\Observers\ContractObserver;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ContractAmendment::observe(ContractAmendmentObserver::class);
        Asset::observe(AssetObserver::class);
        Contract::observe(ContractObserver::class);

        Gate::define('isAdmin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('isManager', function (User $user) {
            return $user->isManager() || $user->isAdmin();
        });
    }
}
