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
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::match(['get', 'post'], '/users', 'UserController@index');
Route::get('/users/create', 'UserController@create');
Route::post('/users/store', 'UserController@store');
Route::get('/users/show/{id}', 'UserController@show');
Route::get('/users/edit/{id}', 'UserController@edit');
Route::put('/users/update/{id}', 'UserController@update');
Route::delete('/users/destroy/{id}', 'UserController@destroy');

Route::match(['get', 'post'], '/reservations', 'ReservationController@index');
Route::get('/reservations/create', 'ReservationController@create');
Route::post('/reservations/store', 'ReservationController@store');
Route::get('/reservations/show/{id}', 'ReservationController@show');
Route::get('/reservations/edit/{id}', 'ReservationController@edit');
Route::put('/reservations/update/{id}', 'ReservationController@update');
Route::delete('/reservations/destroy/{id}', 'ReservationController@destroy');

Route::match(['get', 'post'], '/users-reservations', 'UserReservationController@index');
Route::get('/users-reservations/select/{id}', 'UserReservationController@select');
Route::get('/users-reservations/searchRow/{id}/{column}', 'UserReservationController@searchRow');
Route::post('/users-reservations/store', 'UserReservationController@store');

Route::match(['get', 'post'], '/reports', 'ReportController@index');
Route::get('/reports/report/{id}', 'ReportController@report');

