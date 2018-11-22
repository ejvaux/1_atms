<?php

namespace App\Exports;

use DB;
use App\Ticket;
use App\ClosedTicket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Carbon\Carbon;

class TicketsExport implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
{
    use Exportable;

    public function headings(): array
    {
        return [
            'TICKET #',
            'TICKET OWNER',
            'DEPARTMENT',
            'CATEGORY',
            'PRIORITY',
            'STATUS',
            'SUBJECT',
            'DESCRIPTION',
            'TECH',
            'ROOT CAUSE',
            'ACTION',
            'RESULT',
            'RECOMMENDATION',
            'INSTRUCTION',
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
        return [
            $query->ticket_id,
            $query->user->name,
            $query->department->name,
            $query->category->name,
            $query->priority->name,
            $query->status->name,
            $query->subject,
            $query->message,
            $tech,
            $query->root,
            $query->action,
            $query->result,
            $query->recommend,
            $query->instruction,
            $query->start_at,
            $query->finish_at,
            $query->created_at,
        ];
    }

    public function __construct($user_id = '',$department_id = '',$category_id = '',$priority_id = '',$status_id = '',$assigned_to = '',$created_from = '',$created_to = '')
    {
        $this->user_id = $user_id;
        $this->department_id = $department_id;
        $this->category_id = $category_id;
        $this->priority_id = $priority_id;
        $this->status_id = $status_id;
        $this->assigned_to = $assigned_to;
        $this->created_from = $created_from;
        $this->created_to = $created_to;
    }

    public function query()
    {       
        $ticket = Ticket::select('ticket_id','user_id','department_id','category_id','priority_id','status_id','subject',
        'message','assigned_to','root','action','result','recommend','instruction','start_at','finish_at','created_at');

        $query = ClosedTicket::select('ticket_id','user_id','department_id','category_id','priority_id','status_id','subject',
        'message','assigned_to','root','action','result','recommend','instruction','start_at','finish_at','created_at');

        if( !empty($this->user_id) ){
            $ticket = $ticket->where('user_id',$this->user_id);
            $query = $query->where('user_id',$this->user_id);
        }
        if( !empty($this->department_id) ){
            $ticket = $ticket->where('department_id',$this->department_id);
            $query = $query->where('department_id',$this->department_id);
        }
        if( !empty($this->category_id) ){
            $ticket = $ticket->where('category_id',$this->category_id);
            $query = $query->where('category_id',$this->category_id);
        }
        if( !empty($this->priority_id) ){
            $ticket = $ticket->where('priority_id',$this->priority_id);
            $query = $query->where('priority_id',$this->priority_id);
        }
        if( !empty($this->status_id) ){
            $ticket = $ticket->where('status_id',$this->status_id);
            $query = $query->where('status_id',$this->status_id);
        }
        if( !empty($this->assigned_to) ){
            $ticket = $ticket->where('assigned_to',$this->assigned_to);
            $query = $query->where('assigned_to',$this->assigned_to);
        }
        if( !empty($this->created_from) && !empty($this->created_to) ){            
            $ticket = $ticket->whereBetween('created_at', [Carbon::parse($this->created_from), Carbon::parse($this->created_to)->addDay()]);
            $query = $query->whereBetween('created_at', [Carbon::parse($this->created_from), Carbon::parse($this->created_to)->addDay()]);
        }
        if( !empty($this->created_from) && empty($this->created_to) ){
            $ticket = $ticket->where('created_at','like',$this->created_from.'%');
            $query = $query->where('created_at','like',$this->created_from.'%');
        }
        if( empty($this->created_from) && !empty($this->created_to) ){
            $ticket = $ticket->where('created_at','like',$this->created_to.'%');
            $query = $query->where('created_at','like',$this->created_to.'%');
        }
        return $query->union($ticket)->orderBy('created_at');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return Ticket::all();
    } */
}