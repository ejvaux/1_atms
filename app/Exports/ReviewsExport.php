<?php

namespace App\Exports;

use App\CctvReview;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Carbon\Carbon;

class ReviewsExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
{
    use Exportable;

    public function headings(): array
    {
        return [
            'REQUEST #',
            'REQUEST OWNER',
            'REVIEW START',
            'REVIEW END',
            'LOCATION',
            'DEPARTMENT',            
            'PRIORITY',
            'STATUS',
            'SUBJECT',
            'DESCRIPTION',
            'TECH',
            'ROOT CAUSE',
            'ACTION',
            'RESULT',
            'RECOMMENDATION',
            'APPROVED',
            'APPROVER',
            'APPROVED AT',
            'STARTED',
            'FINISHED',
            'CREATED'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($query): array
    {
        if(!empty($query->assign->name)){
            $tech = $query->assign->name;
        }
        else{
            $tech = '';
        }
        if($query->approved == 1){
            $apprvd = 'YES';
        }
        else{
            $apprvd = 'NO';
        }
        if(!empty($query->approver->name)){
            $apprvr = $query->approver->name;
        }
        else{
            $apprvr = '';
        }

        return [
            $query->request_id,
            $query->user->name,
            $query->start_time,
            $query->end_time,
            $query->locationname->name,
            $query->department->name,
            $query->priority->name,
            $query->status->name,
            $query->subject,
            $query->message,
            $tech,
            $query->root,
            $query->action,
            $query->result,
            $query->recommend,
            $apprvd,
            $apprvr,
            $query->approved_at,
            $query->start_at,
            $query->finish_at,
            $query->created_at,
        ];
    }

    public function __construct($user_id = '',$department_id = '',$location = '',$priority_id = '',$status_id = '',$assigned_to = '',$approved = '',$created_from = '',$created_to = '')
    {
        $this->user_id = $user_id;
        $this->department_id = $department_id;
        $this->location = $location;
        $this->priority_id = $priority_id;
        $this->status_id = $status_id;
        $this->assigned_to = $assigned_to;
        $this->approved = $approved;
        $this->created_from = $created_from;
        $this->created_to = $created_to;
    }

    public function query()
    {       
        $query = CctvReview::select('request_id','user_id','department_id','priority_id','status_id','subject',
        'message','start_time','end_time','location','assigned_to','root','action','result','recommend','start_at','finish_at',
        'approved','approver_id','approved_at','created_at');

        if( !empty($this->user_id) ){
            $query = $query->where('user_id',$this->user_id);
        }
        if( !empty($this->department_id) ){
            $query = $query->where('department_id',$this->department_id);
        }
        if( !empty($this->location) ){
            $query = $query->where('category_id',$this->location);
        }
        if( !empty($this->priority_id) ){
            $query = $query->where('priority_id',$this->priority_id);
        }
        if( !empty($this->status_id) ){
            $query = $query->where('status_id',$this->status_id);
        }
        if( !empty($this->assigned_to) ){
            $query = $query->where('assigned_to',$this->assigned_to);
        }
        if( !empty($this->approved) ){
            $query = $query->where('approved',$this->approved);
        }
        if( !empty($this->created_from) && !empty($this->created_to) ){
            $query = $query->whereBetween('created_at', [Carbon::parse($this->created_from), Carbon::parse($this->created_to)->addDay()]);
        }
        if( !empty($this->created_from) && empty($this->created_to) ){
            $query = $query->where('created_at','like',$this->created_from.'%');
        }
        if( empty($this->created_from) && !empty($this->created_to) ){
            $query = $query->where('created_at','like',$this->created_to.'%');
        }
        return $query->orderBy('created_at','DESC');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return CctvReview::all();
    } */
}
