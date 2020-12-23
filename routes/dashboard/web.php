<?php

 define ('PAGINATION_COUNT' , 2);

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 

        Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){

            Route::get('/' , 'WelcomeController@index')->name('welcome');

            ######################## bgin users Controller  ########################
            Route::resource('users' , 'UserController')->except(['show']);
            ######################## end users Controller  ########################

            ######################## bgin categories Controller  ########################
            Route::resource('categories' , 'CategoryCotroller')->except(['show']);
            ######################## end categories Controller  ########################

            ######################## bgin products Controller  ########################
            Route::resource('products' , 'ProductController')->except(['show']);
            ######################## end products Controller  ########################

            ######################## bgin Clients Controller  ########################
            Route::resource('clients' , 'ClientController')->except(['show']);

            Route::resource('clients.orders' , 'Client\OrderController')->except(['show']);
            ######################## end Clients Controller  ########################

            ######################## bgin orders Controller  ########################
            Route::resource('orders' , 'OrderController')->except(['show']);
            Route::get('/orders/{order}/products' , 'OrderController@products')->name('orders.products');
            ######################## end products Controller  ########################

        
        });

    });


