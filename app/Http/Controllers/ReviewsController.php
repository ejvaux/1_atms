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
    public function reviewlistsearch($id)
    {
        if(Auth::user()->admin == true){
            /* $requests = CctvReview::orderBy('id','desc')->paginate(10); */
            $requests = CctvReview::join('users', 'users.id', '=', 'cctv_reviews.user_id')
                        ->join('priorities', 'priorities.id', '=', 'cctv_reviews.priority_id')
                        ->join('statuses', 'statuses.id', '=', 'cctv_reviews.status_id')
                        ->select('cctv_reviews.*','users.name as username','priorities.name as priority','statuses.name as status')
                        /* ->where('assigned_to',Auth::user()->id) */
                        ->where(function ($query) use($id) {
                            $query->where('cctv_reviews.id','like','%'.$id.'%')
                                ->orWhere('cctv_reviews.request_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('cctv_reviews.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('cctv_reviews.id','desc')
                        ->paginate(10);           
        }
        else{
            /* $requests = CctvReview::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10); */
            $requests = CctvReview::join('users', 'users.id', '=', 'cctv_reviews.user_id')
                        ->join('priorities', 'priorities.id', '=', 'cctv_reviews.priority_id')
                        ->join('statuses', 'statuses.id', '=', 'cctv_reviews.status_id')
                        ->select('cctv_reviews.*','users.name as username','priorities.name as priority','statuses.name as status')                        
                        ->where(function ($query) use($id) {
                            $query->where('user_id',Auth::user()->id)
                                ->orWhere('assigned_to',Auth::user()->id);
                        })
                        ->where(function ($query) use($id) {
                            $query->where('cctv_reviews.id','like','%'.$id.'%')
                                ->orWhere('cctv_reviews.request_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('cctv_reviews.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('cctv_reviews.id','desc')
                        ->paginate(10);
        }        
        return view('tabs.cctv.crl',compact('requests'));
    }
}