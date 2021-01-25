<?php

namespace App\Providers;

use App\Models\Proposal;
use App\Models\Student;
use App\Models\User;
use App\Observers\ProposalObserver;
use App\Observers\StudentObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(){
    	Proposal::observe(ProposalObserver::class);
    	Student::observe(StudentObserver::class);
    	User::observe(UserObserver::class);
    }
}
