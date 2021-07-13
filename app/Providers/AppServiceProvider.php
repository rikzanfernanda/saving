<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        View::composer('layout.user', function ($view) {
            $data['total'] = DB::table('banks')->where('id_user', auth()->user()->id)->sum('saldo');
            $view->with($data);
        });
    }

}
