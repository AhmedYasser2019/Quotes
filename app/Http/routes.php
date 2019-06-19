<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']] , function () {
        Route::get('/{author?}',[
            'uses' => 'QuoteController@getIndex',
            'as' => 'index'
        ]);
        Route::post('/new',[
            'uses' => 'QuoteController@postQuote',
            'as' => 'create'
        ]);
        Route::get('/delete/{quote_id}',[
            'uses' => 'QuoteController@getDeleteQuote',
            'as' => 'delete'
        ]);
        Route::get('/getemail/{author_name}',[
            'uses' => 'QuoteController@getMailCallback',
            'as' => 'mail_callback'
        ]);
        Route::get('/admin/login',[
            'uses' => 'AdminController@getLogin',
            'as' => 'admin.login'
        ]);
        Route::group(['middleware' => 'auth'],function () {

            Route::get('/admin/dashboard',[
                'uses' => 'AdminController@getDashboard',
                'as' => 'admin.dashboard'
            ]);
            Route::get('/admin/quotes',function (){
                return view('admin.admin_quotes');
            });

        });
        Route::post('/admin/login',[
            'uses' => 'AdminController@postLogin',
            'as' => 'admin.login'
        ]);
    Route::get('/admin/logout',[
        'uses' => 'AdminController@getLogout',
        'as' => 'admin.logout'
    ]);

    });
