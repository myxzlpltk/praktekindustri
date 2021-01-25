<?php

namespace App\Providers;

use App\Models\Proposal;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Policies\ProdiPolicy;
use App\Policies\ProposalPolicy;
use App\Policies\SettingPolicy;
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
		Prodi::class => ProdiPolicy::class,
		Proposal::class => ProposalPolicy::class,
		Setting::class => SettingPolicy::class,
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
