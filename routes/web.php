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
    if (Auth::check()) {
        if (Auth::user()->id < 3)
            return view('home');
        else
            return redirect('/'.Auth::user()->username);
    }


    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lily', 'TransactionController@lily');
Route::get('/jesse', 'TransactionController@jesse');
Route::get('/daisy', 'TransactionController@daisy');
Route::get('/update/{id}', 'TransactionController@create');
Route::get('/delete/{id}', 'TransactionController@destroy');
Route::resource('transaction', 'TransactionController');
