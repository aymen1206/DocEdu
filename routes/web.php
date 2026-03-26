<?php

use Illuminate\Support\Facades\Route;

// routes/web.php, api.php or any other central route files you have

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {            
        Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
        {
        Route::get('/','App\Http\Controllers\HomeController@home');
        Route::get('LoginStudent','App\Http\Controllers\HomeController@loginVerifiey')->name('LoginStudent');
        Route::post('loginVerifiey','App\Http\Controllers\GeneralLoginController@loginVerifiey');
        Route::get('rigisterStudent','App\Http\Controllers\HomeController@rigisterStudent')->name('rigisterStudent');        
        Route::post('registerTenant', 'App\Http\Controllers\GeneralLoginController@registerTenant')->name('registerTenant');
      
        });  
    
    });
}