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
        /*
        if (Auth::check()){
            $roles =  Auth::user()->roles;
            //var_dump('AAAAAAAAAAAAAA');
        }else{
            $roles = '';
            //var_dump('BBBBBBBBBBBBBB');
        }
        //var_dump($roles);
        //die();
        $menus = new Menus();
        view()->share('menu', $menus->get( $roles ) );
        */

        view()->composer(['livewire.*'], function($view) {
            //do something awesome here as well
            $countries = ApiReloadlyOperatorCountry::select('name', 'isoName')->groupBy('name', 'isoName')->get();
            $operators = ApiReloadlyOperator::all();
            $view->with(['countries' => $countries, 'operators' => $operators]);
        });


		 \URL::forceScheme('https');
    }
}
