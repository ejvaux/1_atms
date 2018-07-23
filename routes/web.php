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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', 'PagesController@index');
Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@vt');
Route::get('/dashboard/ct', 'DashboardController@ct');
Route::get('/dashboard/cu', 'DashboardController@cu');

// Tables
Route::resource('tickets','TicketsController');
Route::resource('categories','CategoriesController');
Route::resource('priorities','PrioritiesController');



