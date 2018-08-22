<?php

use App\Notifications\Newvisit;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketAccepted;
use App\Notifications\PriorityChanged;
use App\Notifications\StatusChanged;
use App\Notifications\TicketClosed;
use App\Notifications\TicketCreated;

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

Route::get('/testingin', function () {
    return view('welcome');
});

// Notification
Route::get('/notification', function () {
    $user = App\User::first();
    $user->notify(new Newvisit("A new user has visited on your application."));
    return view('welcome'); 
});
Route::get('/notification/ticketassign/{id}/{tid}/{tech}', function ($id,$tid,$tech) {
    /* $user = App\User::first(); */
    $user = App\User::where('id',$id)->first();
    $tech = App\User::where('id',$tech)->first();
    $user->notify(new TicketAssigned($tid,$user->name,'user'));
    $tech->notify(new TicketAssigned($tid,$tech->name,'tech'));
    return redirect('/it/av/'.$tid)->with('success','Ticket Assigned Successfully.'); 
});
Route::get('/notification/ticketaccept/{id}/{tid}/{tech}', function ($id,$tid,$tech) {
    $user = App\User::where('id',$id)->first();
    $user->notify(new TicketAccepted($tid,$user->name,$tech));
    return redirect('/it/htv/'.$tid)->with('success','Ticket Accepted Successfully.'); 
});
Route::get('/notification/ticketpriority/{id}/{tid}/{prio}', function ($id,$tid,$prio) {
    $user = App\User::where('id',$id)->first();
    $user->notify(new PriorityChanged($tid,$user->name,$prio));
    return redirect('/it/htv/'.$tid)->with('success','Priority Changed Successfully.');
});
Route::get('/notification/ticketstatus/{id}/{tid}/{stat}', function ($id,$tid,$stat) {
    $user = App\User::where('id',$id)->first();
    $user->notify(new StatusChanged($tid,$user->name,$stat));
    return redirect('/it/htv/'.$tid)->with('success','Status Changed Successfully.');
});
Route::get('/notification/ticketclose/{id}/{tid}', function ($id,$tid) {
    $user = App\User::where('id',$id)->first();
    $user->notify(new TicketClosed($tid,$user->name));
    return redirect('/it/ht')->with('success','Ticket Closed Successfully.');
});
Route::get('/notification/ticketcreate/{tid}/{mod}', function ($tid,$mod) {
    $users = App\User::where('admin',1)->get();
    foreach ($users as $user) {
        $user->notify(new TicketCreated($tid,$user->name));
    }
    if($mod == 'default'){
        return redirect('/it/ct')->with('success','Ticket Submitted Successfully.');
    }else if($mod == 'admin'){
        return redirect('/it/ac')->with('success','Ticket Submitted Successfully.');
    }
});

Route::get('/', 'PagesController@index');
Auth::routes();
Route::get('/unauthorize', function () {
    return '<h3>Access Denied!</h3>';
});
Route::get('/comingsoon', function () {
    return view('pages.comingsoon');
});

// Email
Route::get('/mail/send/assigned', 'EmailController@send');

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
Route::get('/it/actlv/{id}','DashboardController@adminclosedticketview');
Route::get('/it/ht','DashboardController@handledticket');
Route::get('/it/actl','DashboardController@adminclosedticket');
Route::get('/it/ctl','DashboardController@closedticket');
Route::get('/it/ctlv/{id}','DashboardController@closedticketview');
Route::get('/it/hct','DashboardController@handledclosedticket');
Route::get('/it/hctv/{id}','DashboardController@handledclosedticketview');
Route::get('/it/ahct','DashboardController@adminhandledclosedticket');
Route::get('/it/ahctv/{id}','DashboardController@adminhandledclosedticketview');
Route::get('/it/av/{id}', ['uses' => 'DashboardController@adminviewticket']);
Route::get('/it/ac', 'DashboardController@admincreateticket');
Route::get('/it/lt', 'DashboardController@listticket');
Route::get('/it/vt/{id}', ['uses' => 'DashboardController@viewticket']);
Route::get('/it/htv/{id}', ['uses' => 'DashboardController@viewhandledticket']);
Route::get('/it/ahtv/{id}', ['uses' => 'DashboardController@adminviewhandledticket']);
Route::get('/it/ct', 'DashboardController@createticket');
Route::get('/it/cu', 'DashboardController@contact');

// IT Search
Route::get('/it/al/{id}', ['uses' => 'DashboardController@adminsearchticket']);
Route::get('/it/aq/{id}','DashboardController@searchadminqueue');
Route::get('/it/ahct/{id}','DashboardController@searchadminhandledclosedticket');
Route::get('/it/actl/{id}','DashboardController@searchadminclosedticket');

Route::get('/it/lt/{id}','DashboardController@searchticket');
Route::get('/it/ht/{id}','DashboardController@searchhandledticket');
Route::get('/it/hct/{id}','DashboardController@searchhandledclosedticket');
Route::get('/it/ctl/{id}','DashboardController@searchclosedticket');

// Custom Table Resource
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

Route::get('testing', function () {
    event(new App\Events\TicketCreated('Someone'));
    return "Event has been sent!";
});