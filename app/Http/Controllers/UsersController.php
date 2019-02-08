<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::where('id',$id)->first();
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
        $user = User::find($id);
        if($request->input('name') != ""){ $user->name = $request->input('name');}
        if($request->input('email') != ""){ $user->email = $request->input('email');}
        if($request->input('admin') != ""){ $user->admin = $request->input('admin');}
        if($request->input('tech') != ""){ $user->tech = $request->input('tech');}
        if($request->input('level') != ""){ $user->level = $request->input('level');}
        if($request->input('req_approver') != ""){ $user->req_approver = $request->input('req_approver');}
        if($request->input('hrvr_approval_type') != ""){ $user->hrvr_approval_type = $request->input('hrvr_approval_type');}
        if($request->input('hrvr_approval_dept') != ""){ $user->hrvr_approval_dept = $request->input('hrvr_approval_dept');}
        $user->save();
        if($user->save()){
            if(empty($request->input('mod'))){
                return 'User data updated successfully.';
            }
            else{
                return redirect()->back()->with('success','User data updated successfully.');
            }            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->delete();
        return redirect()->back()->with('success','User Deleted Successfully.');
    }
    public function changepass(Request $request, $id)
    {
        $user = User::find($id);
        $hasher = app('hash');
        $pass = $request->input('curr_password');
        if ($hasher->check($pass, $user->password)) {
            if($request->input('new_password') == $request->input('password')){
                $password = Hash::make($request->input('password'));
                $user->password = $password;
                $user->save();
                return redirect()->back()->with('success','Password updated successfully.');
            }
            else{
                return redirect()->back()->with('error','New Password and Confirm Password are not the same.');
            }
        }
        else{
            return redirect()->back()->with('error','Password is incorrect.');
        }    
    }
}
