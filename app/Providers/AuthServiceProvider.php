<?php

namespace App\Providers;

use App\Models\Proposal;
use App\Models\Student;
use App\Models\User;
use App\Policies\ProposalPolicy;
use App\Policies\StudentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		Proposal::class => ProposalPolicy::class,
		Student::class => StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

		Gate::define('isAdmin', function (User $user){
			return $user->isAdmin;
		});

		Gate::define('isStudent', function (User $user){
			return $user->isStudent;
		});

		Gate::define('isCoordinator', function (User $user){
			return $user->isCoordinator;
		});
    }
}
