<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    
    public function boot()
    {
        $this->routes(function () {

              // Central routes
	        Route::domain('edorasa.com')
        	    ->middleware('web')
            		->group(base_path('routes/web.php'));

//         Tenant routes (subdomains only)
       Route::domain('{tenant}.edorasa.com')
            ->middleware([
                'web',
                \Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain::class,
                \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            ])->group(base_path('routes/tenant.php'));

            Route::prefix(LaravelLocalization::setLocale().'/edu-facility')
                ->as('edu-facility.')
                ->middleware('web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
                ->namespace('App\Http\Controllers\EduFacility')
                ->group(base_path('routes/edu-facility.php'));

        });
// 	Route::middleware('healthy')
  //              ->group(base_path('routes/healthy.php'));

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
   
 
}
