<?php

namespace App\Custom;

use App\Status;
use App\Priority;
use App\Ticket;
use App\Serial;

class CustomFunctions
{
    // Status Format
    public static function status_format($stat){
        $form = '';
        $html = Status::where('id', $stat)->first();
        switch($stat){
            case 1:
                $form = "<span class='badge badge-danger'>" . $html->name . "</span>";
                break;
        
            case 2:
                $form = "<span class='badge badge-info'>" . $html->name . "</span>";
                break;

            case 3:
                $form = "<span class='badge badge-primary'>" . $html->name . "</span>";
                break;

            case 4:
                $form = "<span class='badge badge-warning'>" . $html->name . "</span>";
                break;

            case 5:
                $form = "<span class='badge badge-success'>" . $html->name . "</span>";
                break;

            case 6:
                $form = "<span class='badge badge-secondary'>" . $html->name . "</span>";
                break;
        
            default:
                $form = "<span>Something went wrong, please try again</span>";
        }
        return $form;
    }

    public static function priority_format($prio){
        $form = '';
        $html = Priority::where('id', $prio)->first();    
        switch($prio){
            case 1:
                $form = "<span class='badge badge-success'>" . $html->name . "</span>";
                break;
        
            case 2:
                $form = "<span class='badge badge-info'>" . $html->name . "</span>";
                break;

            case 3:
                $form = "<span class='badge badge-primary'>" . $html->name . "</span>";
                break;

            case 4:
                $form = "<span class='badge badge-warning'>" . $html->name . "</span>";
                break;

            case 5:
                $form = "<span class='badge badge-danger'>" . $html->name . "</span>";
                break;
        
            default:
                $form = "<span>Something went wrong, please try again</span>";
        }
        return $form;
    }

    public static function status_color($stat){
        $form = '';
        $html = Status::where('id', $stat)->first();   
        switch($stat){
            case 1:
                $form = "<span class='text-danger'>" . $html->name . "</span>";
                break;
        
            case 2:
                $form = "<span class='text-info'>" . $html->name . "</span>";
                break;

            case 3:
                $form = "<span class='text-primary'>" . $html->name . "</span>";
                break;

            case 4:
                $form = "<span class='text-warning'>" . $html->name . "</span>";
                break;

            case 5:
                $form = "<span class='text-success'>" . $html->name . "</span>";
                break;

            case 6:
                $form = "<span class='text-secondary'>" . $html->name . "</span>";
                break;
        
            default:
                $form = "<span>Something went wrong, please try again</span>";
        }
        return $form;
    }

    public static function datetimelapse($dt){
        $datetime1 = strtotime($dt);
        $datetime2 = strtotime(date('Y-m-d H:i:s'));
        $secs = $datetime2 - $datetime1;
        if($secs < 60){
            return $secs . " secs ago";
        }
        elseif($secs >= 60 && $secs < 3600){
            $a = floor($secs / 60);            
            if($a>1){
                return $a . " mins ago";
            }
            else{
                return $a . " min ago";
            }              
        }
        elseif($secs >= 3600 && $secs < 86400){
            $a = floor($secs / 3600);
            if($a>1){
                return $a . " hours ago";
            }
            else{
                return $a . " hour ago";
            } 
        }
        elseif($secs >= 86400){
            $a = floor($secs / 86400);
            if($a>1){
                return $a . " days ago";
            }
            else{
                return $a . " day ago";
            } 
        }
    }
    public static function datetimefinished($dt1,$dt2){
        $datetime1 = strtotime($dt1);
        $datetime2 = strtotime($dt2);
        $secs = $datetime2 - $datetime1;              
        $days = floor($secs / (3600*24));
        $secs  -= $days*3600*24;
        $hrs   = floor($secs / 3600);
        $secs  -= $hrs*3600;
        $mnts = floor($secs / 60);
        $secs  -= $mnts*60;
        /* $time = $days . " day, " . $hrs . " hr, " . $mnts . " min"; */
        $time = '';
        if($days > 0){
            $time = $days . " day, ";
        }
        if($hrs > 0){
            $time .= $hrs . " hr, ";
        }
        if($mnts > 0){
            $time .= $mnts . " min";
        }
        return $time;
    }
    public static function generateTicketNumber(){
        $tnum = "MIS";
        $month = date('m');
        $year = date('y');
        /* $month = '09';
        $year = '18'; */
        $tnum .= $year . $month;
        $series = Serial::orderBy('id', 'desc')->first();
        if(empty($series)){
            return $tnum . "001";
        }
        else{
            $tid = $series->number;
            $yr = substr($tid,3,2);
            $mnth = substr($tid,5,2);
            $num = substr($tid,-3);
            if($yr == $year && $mnth == $month){
                return $tnum . str_pad($num+1, 3, '0', STR_PAD_LEFT);
            }
            else if($yr != $year || $mnth != $month){
                return "MIS" . $year . $month . "001";
            }
        }
        /* return $tnum; */
    }
}