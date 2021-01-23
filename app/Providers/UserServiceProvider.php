<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        require_once app_path() . '/Helpers/Proposal.php';
=======
		require_once app_path() . '/Helpers/Helper.php';
>>>>>>> 497335a2a5464cdc8e0db5a12cef2e20c66fa4f2
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
