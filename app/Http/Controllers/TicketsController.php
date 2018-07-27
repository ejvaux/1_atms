<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'priority' => 'required',
            'category' => 'required', 
            'department' => 'required',          
            'message' => 'required',
        ]);

        // Create Ticket

        $t = new Ticket;
        $t->user_id = $request->input('userid');
        $t->department_id = $request->input('department');
        $t->category_id = $request->input('category');
        $t->priority_id = $request->input('priority');
        $t->subject = $request->input('subject');
        $t->message = $request->input('message');
        $t->save();
       if($t->save()){
            /* $departments = Department::orderBy('name')->get();
            $categories = Category::orderBy('id')->get();
            $priorities = Priority::orderBy('id')->get();
            $msg = ["success" => "Ticket Submitted."];
            return view('tabs.it.ct', compact('categories', 'priorities','departments','msg')); */
            return 'Ticket created successfully!';
       }
       /*  return redirect('/it/ct')->with('success','Ticket Submitted.'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ticket::where('id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
