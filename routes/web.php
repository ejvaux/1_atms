<?php

use App\Notifications\Newvisit;
use App\Events\triggerEvent;

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

// User
Route::get('user/update/{id}','DashboardController@userupdate');
Route::get('user/changepass','DashboardController@userchangepass');

// Notification
Route::get('/notification', function () {
    $user = App\User::first();
    $user->notify(new Newvisit("A new user has visited on your application."));
    return view('welcome'); 
});
Route::get('/markallread', 'NotificationController@markallread')->name('markallread');
Route::get('/markread/{id}/{mod}/{tid}','NotificationController@markread');
Route::get('/clearnotif', 'NotificationController@clearnotification')->name('clearnotif');

// Ticket Notification
Route::get('/notification/ticketcreate/{tid}/{mod}', 'NotificationController@ticketcreate');
Route::get('/notification/ticketassign/{id}/{tid}/{tech}', 'NotificationController@ticketassign');
Route::get('/notification/ticketaccept/{id}/{tid}/{tech}', 'NotificationController@ticketaccept');
Route::get('/notification/ticketpriority/{id}/{tid}/{prio}', 'NotificationController@ticketpriority');
Route::get('/notification/ticketstatus/{id}/{tid}/{stat}', 'NotificationController@ticketstatus');
Route::get('/notification/ticketclose/{id}/{tid}', 'NotificationController@ticketclose');
Route::get('/notification/ticketdecline/{id}/{tid}', 'NotificationController@ticketdecline');
Route::get('/notification/ticketupdate/{id}', 'NotificationController@ticketupdate');

// CCTV Review Notification
Route::get('/notification/requestcreate/{tid}', 'NotificationController@requestcreate');
Route::get('/notification/requestassign/{id}/{tid}/{tech}', 'NotificationController@requestassign');
Route::get('/notification/requestaccept/{id}/{tid}/{tech}', 'NotificationController@requestaccept');
Route::get('/notification/requestpriority/{id}/{tid}/{prio}', 'NotificationController@requestpriority');
Route::get('/notification/requeststatus/{id}/{tid}/{stat}', 'NotificationController@requeststatus');

Route::get('/', 'PagesController@index');
Auth::routes();
Route::get('/unauthorize', function () {
    /* return '<h3>Access Denied!</h3><br><a href="/1_atms/public/dashboard">HOME</a>'; */
    return abort(403, 'Unauthorized action.');
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
Route::get('/admin/role/{id}','DashboardController@searchuserview');
Route::get('/protected', function() {
     return "This page requires authentication"; 
})->middleware('auth', 'admin');
Route::get('/admin/export', 'DashboardController@viewexporttab');

// Reports - Tickets
Route::get('/it/rp/today','ReportsController@ticketreportstoday');
Route::get('/it/rp/week','ReportsController@ticketreportsweek');
Route::get('/it/rp/month','ReportsController@ticketreportsmonth');
Route::get('/it/rp/year','ReportsController@ticketreportsyear');
Route::post('/it/rp/range','ReportsController@ticketreportsrange');
// Reports - CCTV Reviews
Route::get('/it/rp/ctoday','Reports2Controller@reviewreportstoday');
Route::get('/it/rp/cweek','Reports2Controller@reviewreportsweek');
Route::get('/it/rp/cmonth','Reports2Controller@reviewreportsmonth');
Route::get('/it/rp/cyear','Reports2Controller@reviewreportsyear');
Route::post('/it/rp/crange','Reports2Controller@reviewreportsrange');

// MIS
Route::get('/it/al', 'DashboardController@adminlistticket')->middleware('auth', 'admin');
Route::get('/it/aq','DashboardController@adminqueue')->middleware('auth', 'admin');
Route::get('/it/actlv/{id}','DashboardController@adminclosedticketview')->middleware('auth', 'admin');
Route::get('/it/ht','DashboardController@handledticket');
Route::get('/it/actl','DashboardController@adminclosedticket')->middleware('auth', 'admin');
Route::get('/it/ctl','DashboardController@closedticket');
Route::get('/it/ctlv/{id}','DashboardController@closedticketview');
Route::get('/it/hct','DashboardController@handledclosedticket');
Route::get('/it/hctv/{id}','DashboardController@handledclosedticketview');
Route::get('/it/ahct','DashboardController@adminhandledclosedticket')->middleware('auth', 'admin');
Route::get('/it/ahctv/{id}','DashboardController@adminhandledclosedticketview')->middleware('auth', 'admin');
Route::get('/it/av/{id}', 'DashboardController@adminviewticket')->middleware('auth', 'admin');
Route::get('/it/ac', 'DashboardController@admincreateticket')->middleware('auth', 'admin');
Route::get('/it/lt', 'DashboardController@listticket');
Route::get('/it/vt/{id}', ['uses' => 'DashboardController@viewticket']);
Route::get('/it/htv/{id}', ['uses' => 'DashboardController@viewhandledticket']);
Route::get('/it/ahtv/{id}', ['uses' => 'DashboardController@adminviewhandledticket'])->middleware('auth', 'admin');
Route::get('/it/ct', 'DashboardController@createticket');
Route::get('/it/cu', 'DashboardController@contact');
Route::get('/it/dtl','DashboardController@declinedticket');
Route::get('/it/dtv/{id}','DashboardController@declinedticketview');
Route::get('/it/tda/{id}','DashboardController@viewticketattach');
Route::get('/it/ctda/{id}','DashboardController@viewcticketattach');
Route::get('/it/dtda/{id}','DashboardController@viewdticketattach');
// Load list
Route::get('/loadticketlist/{id}','DashboardController@loadticketlist');

// IT Search
Route::get('/it/al/{id}', ['uses' => 'DashboardController@adminsearchticket']);
Route::get('/it/aq/{id}','DashboardController@searchadminqueue');
Route::get('/it/ahct/{id}','DashboardController@searchadminhandledclosedticket');
Route::get('/it/actl/{id}','DashboardController@searchadminclosedticket');
Route::get('/it/dtl/{id}','DashboardController@searchdeclinedticket');

Route::get('/it/lt/{id}','DashboardController@searchticket');
Route::get('/it/ht/{id}','DashboardController@searchhandledticket');
Route::get('/it/hct/{id}','DashboardController@searchhandledclosedticket');
Route::get('/it/ctl/{id}','DashboardController@searchclosedticket');

// CCTV Review
Route::get('/cr/crl','ReviewsController@reviewlist');
Route::get('/cr/rcrl','ReviewsController@rejectedreviewlist');
Route::get('/cr/crc','ReviewsController@reviewcreate');
Route::get('/cr/crv/{id}','ReviewsController@viewreview');
Route::get('/cr/rcrv/{id}','ReviewsController@viewrejectedreview');
Route::get('/cr/crda/{id}','ReviewsController@viewreviewattach');

// Download Report
Route::get('/report/{fn}','ReviewsController@downloadreport');

// Load list
Route::get('/loadlist/{id}','ReviewsController@loadlist');
// Search
Route::get('/cr/crl/{id}','ReviewsController@reviewlistsearch');

// Custom Table Resource
Route::post('closed_ticket/transfer/{id}','ClosedTicketController@transferticket');
Route::post('declined_ticket/transfer/{id}','DeclinedTicketController@transferticket');
Route::put('users/changepass/{id}','UsersController@changepass');
Route::put('cctvreview/addimage/{id}','CctvReviewsController@addimage');
Route::post('rejectedrequest/reject/{id}','RejectedRequestController@reject');

// Tables
Route::resources([
    'users' => 'UsersController',
    'tickets' => 'TicketsController',
    'categories' => 'CategoriesController',
    'priorities' => 'PrioritiesController',
    'ticket_updates' => 'TicketUpdatesController',
    'closed_ticket' => 'ClosedTicketController',
    'cctvreview' => 'CctvReviewsController',
    'declined_ticket' => 'DeclinedTicketController',
    'rejectedrequest' => 'RejectedRequestController',
    'vehiclerequest' => 'VehicleRequestController',
]);

// Exporting
Route::post('/admin/ticket/export', 'TicketsController@export');
Route::post('/admin/request/export', 'CctvReviewsController@export');

// Load divs
Route::get('nvbr', function () {
    return view('inc.navbar');
});
Route::get('ddmenu', function () {
    return view('inc.dropdownmenu');
});
Route::get('getunreadnotif', 'DashboardController@getunreadnotif');

/*
*
*   HR
*
*/ 
// Vehicle Request
Route::get('/hr/vrl','hr\VehicleRequestController@vehiclelistview');
Route::get('/hr/cvr','hr\VehicleRequestController@createvehiclerequest');
Route::get('/hr/vrv/{id}','hr\VehicleRequestController@viewvehiclerequest');
Route::get('/hr/vra','hr\VehicleRequestController@vehicleapprovedlistview');
// Search
Route::get('/hr/vrl/{id}','hr\VehicleRequestController@searchvehiclelistview');
Route::get('/hr/vra/{id}','hr\VehicleRequestController@searchvehicleapprovedlistview');
// Approval 
Route::post('/hr/vra/{id}','hr\VehicleRequestController@approvevehiclerequest');

/*
*
*   TEST
*
*/ 
Route::get('testing', function () {
    event(new App\Events\TicketCreated('Someone'));
    return "Event has been sent!";
});
Route::get('event', function () {
    event(new NotificationTask(Auth::user(),'TEST'));
});
Route::get('listen', function () {
    return view('listenBroadcast');
});
Route::get('tdb', 'DashboardController@testdb');
Route::get('dnotif', function () {
    return view('testnotif');
});