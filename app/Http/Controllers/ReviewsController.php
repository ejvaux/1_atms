<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Priority;
use App\Department;
use App\Location;
use App\CctvReview;
use Auth;
use App\User;
use App\ReviewStatus;

class ReviewsController extends Controller
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
        //
    }
    public function reviewlist()
    {
        if(Auth::user()->admin == true){
            $requests = CctvReview::orderBy('id','desc')->paginate(10);
            /* if($id == 'all'){
                $requests = CctvReview::orderBy('id','desc')->paginate(10);
            }
            else if($id == 'assign'){
                $requests = CctvReview::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            } */
        }
        else{
            $requests = CctvReview::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            /* if($id == 'all'){
                $requests = CctvReview::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            }
            else if($id == 'assign'){
                $requests = CctvReview::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            } */
        }        
        return view('tabs.cctv.crl',compact('requests'));
    }
    public function reviewcreate()
    {
        $departments = Department::orderBy('name')->get();
        $priorities = Priority::orderBy('id')->get();
        $locations = Location::orderBy('name')->get();
        return view('tabs.cctv.crc',compact('departments','priorities','locations'));
    }
    public function viewreview($id)
    {
        $statuses = ReviewStatus::orderBy('id')->get();
        $priorities = Priority::orderBy('id')->get();
        $techs = User::where('tech',true)->get();
        $request = CctvReview::where('id',$id)->first();
        $departments = Department::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('tabs.cctv.crv',compact('request','departments','locations','techs','priorities','statuses'));
    }
    public function loadlist($id){
        if(Auth::user()->admin == true){           
            if($id == '1'){
                $requests = CctvReview::orderBy('id','desc')->paginate(10);
            }
            else if($id == '2'){
                $requests = CctvReview::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            }
        }
        else{            
            if($id == '1'){
                $requests = CctvReview::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            }
            else if($id == '2'){
                $requests = CctvReview::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
            }        
        }
        return view('inc.requestlist',compact('requests'));
    }
}
