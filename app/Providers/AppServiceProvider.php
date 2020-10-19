<?php

namespace App\Providers;

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
		\URL::forceScheme('https');
    }
}
