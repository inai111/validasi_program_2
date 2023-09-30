<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewAnyReport', function (User $user) {
            return !$user->roles->isEmpty();
        });
        Gate::define('viewIncomingReport', function (User $user) {
            return $user->roles->contains(function($value){
                    return in_array($value['name_code'],['kabag','direct']);
                });
        });
    }
}
