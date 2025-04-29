<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('access-admin', function ($user) {
            return $user->hasRole(['Admin']);
        });
        
        Gate::define('access-rtb-staff', function ($user) {
            return $user->hasRole(['RTB-Staff']);
        });
        
        Gate::define('access-technician', function ($user) {
            return $user->hasRole(['Technician']);
        });
        
        Gate::define('access-school', function ($user) {
            return $user->hasRole(['School']);
        });
        
        Gate::define('access-admin-rtb-staff', function ($user) {
            return $user->hasRole(['Admin', 'RTB-Staff']);
        });
        
        Gate::define('access-admin-technician', function ($user) {
            return $user->hasRole(['Admin', 'Technician']);
        });
        
        Gate::define('access-admin-school', function ($user) {
            return $user->hasRole(['Admin', 'School']);
        });
        
        Gate::define('access-rtb-staff-technician', function ($user) {
            return $user->hasRole(['RTB-Staff', 'Technician']);
        });
        
        Gate::define('access-rtb-staff-school', function ($user) {
            return $user->hasRole(['RTB-Staff', 'School']);
        });
        
        Gate::define('access-technician-school', function ($user) {
            return $user->hasRole(['Technician', 'School']);
        });
        
        Gate::define('access-admin-rtb-staff-technician', function ($user) {
            return $user->hasRole(['Admin', 'RTB-Staff', 'Technician']);
        });
        
        Gate::define('access-admin-rtb-staff-school', function ($user) {
            return $user->hasRole(['Admin', 'RTB-Staff', 'School']);
        });
        
        Gate::define('access-admin-technician-school', function ($user) {
            return $user->hasRole(['Admin', 'Technician', 'School']);
        });
        
        Gate::define('access-rtb-staff-technician-school', function ($user) {
            return $user->hasRole(['RTB-Staff', 'Technician', 'School']);
        });
        
        Gate::define('access-admin-rtb-staff-technician-school', function ($user) {
            return $user->hasRole(['Admin', 'RTB-Staff', 'Technician', 'School']);
        });
        
}}