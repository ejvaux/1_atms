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
Route::get('/unauthorize', function () {
    return '<h3>Access Denied!</h3>';
});
Route::get('/comingsoon', function () {
    return view('pages.comingsoon');
});

// Dashboard
Route::get('/dashboard', 'DashboardController@index');

// HOME
Route::get('/home/dt', 'DashboardController@viewdashtab');
/* Route::get('/protected', ['middleware' => ['auth', 'admin'], function() {
     return "this page requires that you be logged in and an Admin"; 
}]); */
/* Route::get('/admin', ['middleware' => ['auth', 'admin'], function() {
    return "this page requires that you be logged in and an Admin"; 
}]); */

// IT
Route::get('/it/al', 'DashboardController@adminlistticket');
Route::get('/it/av/{id}', ['uses' => 'DashboardController@adminviewticket']);
Route::get('/it/lt', 'DashboardController@listticket');
Route::get('/it/vt/{id}', ['uses' => 'DashboardController@viewticket']);
Route::get('/it/ct', 'DashboardController@createticket');
Route::get('/it/cu', 'DashboardController@contact');

// Tables
Route::resource('tickets','TicketsController');
Route::resource('categories','CategoriesController');
Route::resource('priorities','PrioritiesController');
Route::resource('ticket_updates','TicketUpdatesController');