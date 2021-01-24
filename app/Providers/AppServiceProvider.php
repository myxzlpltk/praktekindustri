<?php

namespace App\Providers;

use App\Models\Setting;
use Carbon\Carbon;
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
    }
}
