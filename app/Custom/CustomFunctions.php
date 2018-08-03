<?php

namespace App\Custom;

use App\Status;
use App\Priority;

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
}