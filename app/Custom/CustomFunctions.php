<?php

namespace App\Custom;

use App\Status;
use App\Priority;
use App\Ticket;
use App\Serial;
use App\ReviewSerial;
use App\ReviewStatus;

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
            case 7:
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
            case 7:
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
    public static function generateRequestNumber(){
        $tnum = "MIS";
        $month = date('m');
        $year = date('y');
        /* $month = '09';
        $year = '18'; */
        $tnum .= $year . $month;
        $series = ReviewSerial::orderBy('id', 'desc')->first();
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
    public static function colorsets(){
        /* $col = ['red','blue','yellow','tomato','orange','violet']; */
        /* $col = ['#641E16','#512E5F','#154360','#0E6251','#145A32','#7D6608','#784212','#7B7D7D','#4D5656','#1B2631','#78281F','#4A235A','#1B4F72','#0B5345','#186A3B','#7E5109','#6E2C00','#626567','#424949','#17202A']; */
        $col =[
            '#99A3A4',
            '#42a5f5',
            '#5c6bc0',
            '#7e57c2',
            '#ab47bc',
            '#ec407a',
            '#ef5350',
            '#d4e157',
            '#9ccc65',
            '#66bb6a',
            '#26a69a',
            '#26c6da',
            '#29b6f6',
            '#bdbdbd',
            '#8d6e63',
            '#ff7043',
            '#ffa726',
            '#ffee58',
            '#ffca28',
            '#78909C'
        ];
        return $col;
    }
    public static function r_status_color($stat){
        $form = '';
        $html = ReviewStatus::where('id', $stat)->first();   
        switch($stat){
            case 1:
                $form = "<span class='text-success'>" . $html->name . "</span>";
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
                $form = "<span class='text-danger'>" . $html->name . "</span>";
                break;
            case 7:
                $form = "<span class='text-secondary'>" . $html->name . "</span>";
                break;
            default:
                $form = "<span>Something went wrong, please try again</span>";
        }
        return $form;
    }
    public static function r_status_format($stat){
        $form = '';
        $html = ReviewStatus::where('id', $stat)->first();
        switch($stat){
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
                $form = "<span class='badge badge-success'>" . $html->name . "</span>";
                break;
            case 6:
                $form = "<span class='badge badge-danger'>" . $html->name . "</span>";
                break;
            case 7:
                $form = "<span class='badge badge-secondary'>" . $html->name . "</span>";
                break;
            default:
                $form = "<span>Something went wrong, please try again</span>";
        }
        return $form;
    }
}