<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
     Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
        {
        Route::get('/','App\Http\Controllers\HomeController@home');
        Route::get('LoginStudent','App\Http\Controllers\HomeController@loginVerifiey')->name('LoginStudent');
        Route::post('loginVerifiey','App\Http\Controllers\GeneralLoginController@loginVerifiey');
        Route::get('rigisterStudent','App\Http\Controllers\HomeController@rigisterStudent')->name('rigisterStudent');        
        Route::post('registerTenant', 'App\Http\Controllers\GeneralLoginController@registerTenant')->name('registerTenant');
        });  
});

