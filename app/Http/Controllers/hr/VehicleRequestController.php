<?php

namespace App\Http\Controllers\hr;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Custom\NotificationFunctions;
use App\Department;
use App\Vehicle;
use App\VehicleRequest;
use App\VehicleApproval;
use App\VehicleApprovalType;
use Auth;


class VehicleRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->departments = Department::orderBy('name')->get();
        $this->vrequestapprovaltypes = VehicleApprovalType::orderBy('id')->get();
        $this->vehicles = Vehicle::orderBy('name')->get();
    }
    public function vehiclelistview()
    {
        if (Auth::user()->isadmin()) {
            $vrequests = VehicleRequest::where('approval_id','!=',$this->vrequestapprovaltypes->count())->orderBy('approval_id')->paginate('10');
        } else {
            if (Auth::user()->hrvr_approval_type != 0) {

                $vrequests = VehicleRequest::where(function($query)
                            {
                                if (Auth::user()->hrvr_approval_type == 1 || Auth::user()->hrvr_approval_type == 2) {
                                    $query->where('approval_id',Auth::user()->hrvr_approval_type)
                                    ->where('department_id',Auth::user()->hrvr_approval_dept);
                                } elseif (Auth::user()->hrvr_approval_type == 3 || Auth::user()->hrvr_approval_type == 4) {
                                    $query->where('approval_id',Auth::user()->hrvr_approval_type);
                                }                                
                            })                            
                            ->orwhere('created_by',Auth::user()->id)
                            ->orderByRaw(
                                "CASE
                                WHEN `approval_id` = ". Auth::user()->hrvr_approval_type ." THEN 1
                                WHEN `created_by` = ". Auth::user()->id ." THEN 2
                                ELSE 3 END DESC"
                            )
                            ->paginate('10');
            } else {
                $vrequests = VehicleRequest::where('created_by',Auth::user()->id)
                ->orderBy('approval_id')
                ->paginate('10');
            }            
        }
        
        $vrequestapprovaltypes = $this->vrequestapprovaltypes;
        return view('tabs.hr.vrl',compact('vrequests','vrequestapprovaltypes'));
    }
    public function vehicleapprovedlistview()
    {   
        if (Auth::user()->isadmin()) {
            $vrequests = VehicleRequest::where('approval_id',$this->vrequestapprovaltypes->count())->orderBy('approval_id')->paginate('10');
        } else {
            if (Auth::user()->hrvr_approval_type != 0) {

                $vrequests = VehicleRequest::where(function($query)
                            {
                                if (Auth::user()->hrvr_approval_type == 1 || Auth::user()->hrvr_approval_type == 2) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type)
                                    ->where('department_id',Auth::user()->hrvr_approval_dept);
                                } elseif (Auth::user()->hrvr_approval_type == 3 || Auth::user()->hrvr_approval_type == 4) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type);
                                }                                
                            })
                            /* ->orwhere('created_by',Auth::user()->id) */
                            /* ->orderBy('id','DESC') */
                            ->orderByRaw(
                                "CASE
                                WHEN `approval_id` = ". Auth::user()->hrvr_approval_type ." THEN 1
                                ELSE 2 END DESC"
                            )
                            ->paginate('10');
            }         
        }
        $vrequestapprovaltypes = $this->vrequestapprovaltypes;
        return view('tabs.hr.vra',compact('vrequests','vrequestapprovaltypes'));
    }
    public function createvehiclerequest()
    {   
        $departments = $this->departments;
        return view('tabs.hr.cvr',compact('departments'));
    }
    public function viewvehiclerequest($id)
    {
        $vrequest = VehicleRequest::where('id',$id)->first();
        $vehicles = $this->vehicles;
        $vrequestapprovals = VehicleApproval::where('vehicle_request_id',$id)->get();
        $vrequestapprovaltypes = $this->vrequestapprovaltypes;
        $departments = $this->departments;
        return view('tabs.hr.vrv',compact('vrequest','vrequestapprovals','vrequestapprovaltypes','vehicles','departments'));
    }
    public function approvevehiclerequest(Request $request, $id)
    {
        $apprvltype = Auth::user()->hrvr_approval_type;
        // Update Approval in Vehicle Request
        $vr = VehicleRequest::find($id);
        $approver = $apprvltype + 1;
        $requestid = $vr->id;
        $creator = $vr->created_by;
        $adept = $vr->department_id;
        $vr->approval_id = $apprvltype + 1;
        $vr->save();

        // Checking duplicate approval
        $chk = VehicleApproval::where('vehicle_request_id',$id)->where('approval_id',$apprvltype)->get();

        // Insert Approval in Vehicle Approvals
        if($chk->count() == 0){
            $vra = new VehicleApproval;
            $vra->vehicle_request_id = $id;
            $vra->approval_id = $apprvltype;
            $vra->approver_id = Auth::user()->id;
            $vra->save();
        }        

        // Notification $this->vrequestapprovaltypes
        if($approver > $this->vrequestapprovaltypes->count()){
            NotificationFunctions::vehiclerequestapproved($creator,$requestid);
        } else{
            if($approver < 3){
                NotificationFunctions::approvevehiclerequest($approver,$requestid,$adept);
            }
            else{
                NotificationFunctions::approvevehiclerequest($approver,$requestid,0);
            }            
        }        

        return redirect()->back()->with('success','Vehicle Request Approved Successfully.');
    }
    public function searchvehiclelistview($id)
    {
        if(Auth::user()->isadmin()){
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->paginate('10');
        } elseif (Auth::user()->hrvr_approval_type != 0){
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->where(function($query)
                            {
                                if (Auth::user()->hrvr_approval_type == 1 || Auth::user()->hrvr_approval_type == 2) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type)
                                    ->where('department_id',Auth::user()->hrvr_approval_dept);
                                } elseif (Auth::user()->hrvr_approval_type == 3 || Auth::user()->hrvr_approval_type == 4) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type);
                                }                                
                            })
                            ->orderByRaw(
                                "CASE
                                WHEN `approval_id` = ". Auth::user()->hrvr_approval_type ." THEN 1
                                ELSE 2 END DESC"
                            )
                            ->paginate('10');
        } else {
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->where('created_by',Auth::user()->id)
                ->orderBy('approval_id')
                ->paginate('10');
        }
        $vrequestapprovaltypes = $this->vrequestapprovaltypes;
        return view('tabs.hr.vrl',compact('vrequests','vrequestapprovaltypes'));
    }
    public function searchvehicleapprovedlistview($id)
    {
        if(Auth::user()->isadmin()){
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->paginate('10');
        } elseif (Auth::user()->hrvr_approval_type != 0){
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->where(function($query)
                            {
                                if (Auth::user()->hrvr_approval_type == 1 || Auth::user()->hrvr_approval_type == 2) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type)
                                    ->where('department_id',Auth::user()->hrvr_approval_dept);
                                } elseif (Auth::user()->hrvr_approval_type == 3 || Auth::user()->hrvr_approval_type == 4) {
                                    $query->where('approval_id','>=',Auth::user()->hrvr_approval_type);
                                }                                
                            })
                            ->orderByRaw(
                                "CASE
                                WHEN `approval_id` = ". Auth::user()->hrvr_approval_type ." THEN 1
                                ELSE 2 END DESC"
                            )
                            ->paginate('10');
        } else {
            $vrequests = VehicleRequest::where('vehicle_request_serial','LIKE','%'.$id.'%')->where('created_by',Auth::user()->id)
                ->orderBy('approval_id')
                ->paginate('10');
        }
        $vrequestapprovaltypes = $this->vrequestapprovaltypes;
        return view('tabs.hr.vra',compact('vrequests','vrequestapprovaltypes'));
    }
}
