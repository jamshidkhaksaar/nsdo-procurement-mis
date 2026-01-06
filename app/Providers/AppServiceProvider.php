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
        Gate::define('isAdmin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('isManager', function ($user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        \App\Models\Asset::observe(\App\Observers\AssetObserver::class);
        \App\Models\Contract::observe(\App\Observers\ContractObserver::class);

        // Dynamic SMTP Configuration
        try {
            if (config('app.env') !== 'testing') {
                $mailHost = \App\Models\Setting::get('mail_host');
                if ($mailHost) {
                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.host' => $mailHost,
                        'mail.mailers.smtp.port' => \App\Models\Setting::get('mail_port', 587),
                        'mail.mailers.smtp.username' => \App\Models\Setting::get('mail_username'),
                        'mail.mailers.smtp.password' => \App\Models\Setting::get('mail_password'),
                        'mail.mailers.smtp.encryption' => \App\Models\Setting::get('mail_encryption', 'tls'),
                        'mail.from.address' => \App\Models\Setting::get('mail_from_address'),
                        'mail.from.name' => \App\Models\Setting::get('mail_from_name', 'Procurement MIS'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Database might not be migrated yet or connection issue
        }
    }
}
