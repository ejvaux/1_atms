<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Division;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticket_id = Ticket::select('id')->orderBy('id','desc')->first();
        if(!$ticket_id){
            $ticket_id = 1;
        }
        else{
            $ticket_id->id++;
        }
        $divisions = Division::select('DIVISION_ID','DIVISION_NAME')->orderBy('DIVISION_NAME')->get();
        $categories = Category::orderBy('name')->get();
        $priorities = Priority::orderBy('name')->get();
        return view('pages.dashboard', compact('categories', 'priorities','divisions','ticket_id'));
    }
}
