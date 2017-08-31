<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
    
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('scrap','ScrapingController@index');
    
    Route::get('post/view/{id}','PostController@view'); 
    Route::get('post/edit/{id}','PostController@edit'); 
    Route::post('post/update/{id}','PostController@update'); 
    Route::get('post/delete/{id}','PostController@delete'); 
});
