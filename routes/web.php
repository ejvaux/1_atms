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
Route::get('/admin/role','DashboardController@viewroles');
/* Route::get('/protected', ['middleware' => ['auth', 'admin'], function() {
     return "this page requires that you be logged in and an Admin"; 
}]); */
/* Route::get('/admin', ['middleware' => ['auth', 'admin'], function() {
    return "this page requires that you be logged in and an Admin"; 
}]); */

// IT
Route::get('/it/al', 'DashboardController@adminlistticket');
Route::get('/it/aq','DashboardController@adminqueue');
Route::get('/it/ht','DashboardController@handledticket');
Route::get('/it/ht/{id}','DashboardController@searchhandledticket');
Route::get('/it/actl','DashboardController@adminclosedticket');
Route::get('/it/ctl','DashboardController@closedticket');
Route::get('/it/ctl/{id}','DashboardController@searchclosedticket');
Route::get('/it/ctlv/{id}','DashboardController@closedticketview');
Route::get('/it/hct','DashboardController@handledclosedticket');
Route::get('/it/hct/{id}','DashboardController@searchhandledclosedticket');
Route::get('/it/hctv/{id}','DashboardController@handledclosedticketview');
Route::get('/it/ahct','DashboardController@adminhandledclosedticket');
Route::get('/it/ahctv/{id}','DashboardController@adminhandledclosedticketview');
Route::get('/it/al/{id}', ['uses' => 'DashboardController@adminsearchticket']);
Route::get('/it/lt/{id}','DashboardController@searchticket');
Route::get('/it/av/{id}', ['uses' => 'DashboardController@adminviewticket']);
Route::get('/it/ac', 'DashboardController@admincreateticket');
Route::get('/it/lt', 'DashboardController@listticket');
Route::get('/it/lt/{id}','DashboardController@searchticket');
Route::get('/it/vt/{id}', ['uses' => 'DashboardController@viewticket']);
Route::get('/it/htv/{id}', ['uses' => 'DashboardController@viewhandledticket']);
Route::get('/it/ahtv/{id}', ['uses' => 'DashboardController@adminviewhandledticket']);
Route::get('/it/ct', 'DashboardController@createticket');
Route::get('/it/cu', 'DashboardController@contact');

// Custom Tables
Route::post('closed_ticket/transfer/{id}','ClosedTicketController@transferticket');

// Tables
Route::resources([
    'users' => 'UsersController',
    'tickets' => 'TicketsController',
    'categories' => 'CategoriesController',
    'priorities' => 'PrioritiesController',
    'ticket_updates' => 'TicketUpdatesController',
    'closed_ticket' => 'ClosedTicketController',
]);