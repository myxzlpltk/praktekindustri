<?php

namespace App\Providers;

use App\Models\Coordinator;
use App\Models\Leader;
use App\Models\Setting;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
		if($this->app->environment('production')) {
			URL::forceScheme('https');
		}

    	/* Load Setting */
		if (Schema::hasTable('settings')) {
			foreach (Setting::all() as $setting) {
				Config::set('settings.'.$setting->key, $setting->value);
			}
		}

		/* Locale id_ID */
		config(['app.locale' => 'id']);
		Carbon::setLocale('id');
		Paginator::useBootstrap();

		/* Morph Map */
		Relation::morphMap([
			'admin' => Leader::class,
			'coordinator' => Coordinator::class,
			'student' => Student::class,
		]);
    }
}
