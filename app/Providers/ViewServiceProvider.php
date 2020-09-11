<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
    public function boot()
    {
        // Using class based composers... (Example)
        // View::composer('blog.*', 'App\Http\View\Composers\BlogComposer');

        // SideBar Data
        View::composer('*', 'App\Http\View\Composers\SideBarComposer');

        // Top-bar Data (Site Logo link, Login options, other links, etc...)
        View::composer('*', 'App\Http\View\Composers\TopBarComposer');
    }
}
