<?php

namespace App\Providers;
 
use Illuminate\Support\Facades\URL;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;   
use Tinify\Tinify;
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
        Paginator::useTailwind(); 
        Paginator::useBootstrap(); 
        \Tinify\setKey(config('services.tinify.key'));
        if (request()->getHost() === 'DocEdu.com') {
            URL::forceScheme('https');
        }
          //URL::forceScheme('https');
       
    }
}
