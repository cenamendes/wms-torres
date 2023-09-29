<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tenant\RandomColors;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;


if (! function_exists('getCustomerConfig')) {
    function global_tenancy_asset($path)
    {
        return URL::to('/') . '/cl/' . tenant('id') . $path;
    }

    function global_hours_format($hour)
    {
        return strtok($hour,':').__("h ").substr($hour, strpos($hour, ":") + 1);
    }

    function global_hours_sum($get_hours)
    {
        $sum_minutes = 0;

      
        foreach($get_hours as $hour)
        {
            $explodedTime = array_map('intval',explode(':',$hour->total_hours));
            $sum_minutes += $explodedTime[0]*60+$explodedTime[1];
        }
            

        if(strlen(floor($sum_minutes/60)) == 1){
            $hoursCheck = '0'.floor($sum_minutes/60);
        }
        else {
            $hoursCheck = floor($sum_minutes/60);
        }

        if(strlen(floor($sum_minutes % 60)) == 1){
            $minutesCheck = '0'.floor($sum_minutes % 60);
        }
        else {
            $minutesCheck = floor($sum_minutes % 60);
        }

        $sumTime = $hoursCheck. ':' .$minutesCheck;


        return global_hours_format($sumTime);
    }

    function get_day_name($timestamp) {

        $date = $timestamp;

        if(date('y-m-d',strtotime($timestamp)) == date('y-m-d',strtotime("now"))) {
          $date = 'Hoje, '.date("H:i",strtotime($date));
        } 
        else if(date('y-m-d',strtotime($timestamp)) == date('y-m-d',strtotime("-1 day"))) {
          $date = 'Ontem, '.date("H:i",strtotime($date));
        }

        return $date;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function parsePercent($original, $current, int $precision = 2) {
        if($original == 0 && $current != 0)
        {
            $round = round($original * 100,$precision);
            return round($current * 100,$precision);
        }
        else if($original != 0 && $current == 0)
        {
            $round = round($original * 100,$precision);
            return abs($round);
        }
        else if($original == 0 && $current == 0)
        {
            $round = round(0,$precision);
            return abs($round);
        }

        $round = round(
            ($current - $original) / min($original, $current) * 100,
            $precision
        );
        return abs($round);
    }


    function random_color($numero_cor) {

        $colors = RandomColors::where('id',$numero_cor)->first();
        
        return $colors;
    }

    function countDaysBetweenDates($date1)
    {
        $now = time();
        $date_second = strtotime($date1);
        $datediff = $now - $date_second;

        return round($datediff / (60 * 60 * 24));
    }


}


