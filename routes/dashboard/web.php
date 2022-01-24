<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard;

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function() {
        Route::get('/dashboard', 'DashboardController@index')->name('index'); 
      
            //categories controller
             Route::resource('categories' , 'CategoryController');
            //productcontroller 
             Route::resource('products' , 'ProductController');
             //usercontroller 
             Route::resource('clients' , 'ClientController');
             //ordercontroller 
             Route::resource('clients.orders' , 'Client\OrderController');
              //usercontroller 
            Route::resource('users' , 'UsersController');
    });
});

