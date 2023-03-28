<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
        view()->composer('layouts.pos.partials.sidemenu', function($view){
            $modules = ModuleMaster::where('status', 1)->orderBy('sort_order')->get();
            $submodules = SubmoduleMaster::where('status',1)->orderBy('sort_order')->get();
            $view->with(['modules' => $modules, 'submodules' => $submodules]);
        });
    }
}
