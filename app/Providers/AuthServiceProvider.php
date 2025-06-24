<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Định nghĩa quyền admin
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // ✅ Thêm định nghĩa quyền patient
        Gate::define('isPatient', function (User $user) {
            return $user->role === 'patient';
        });
    }
}
