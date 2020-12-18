<?php

namespace App\Providers;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorCountry;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
//use App\Http\Menus\Menus;

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
    public function boot()
    {

        view()->composer(['livewire.*'], function($view) {
            $countries = ApiReloadlyOperatorCountry::select('name', 'isoName')->orderBy('name')->groupBy('name', 'isoName')->get();
            $operators = ApiReloadlyOperator::all();
            $view->with(['countries' => $countries, 'operators' => $operators]);
        });


//		 \URL::forceScheme('https');
    }
}
