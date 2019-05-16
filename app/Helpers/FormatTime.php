<?php
namespace App\Helpers;
  
use Illuminate\Support\Facades\DB;
  
class FormatTime {
 
    public static function LongTimeFilter($date) {
        if ($date == null) {
            return "without date";
        }
 
        $start_date = $date;
        $since_start = $start_date->diff(new \DateTime(date("Y-m-d") . " " . date("H:i:s")));
 
        if ($since_start->y == 0) {
            if ($since_start->m == 0) {
                if ($since_start->d == 0) {
                    if ($since_start->h == 0) {
                        if ($since_start->i == 0) {
                            if ($since_start->s == 0) {
                                $result = $since_start->s . ' seconds';
                            } else {
                                if ($since_start->s == 1) {
                                    $result = $since_start->s . ' second';
                                } else {
                                    $result = $since_start->s . ' seconds';
                                }
                            }
                        } else {
                            if ($since_start->i == 1) {
                                $result = $since_start->i . ' minute';
                            } else {
                                $result = $since_start->i . ' minutes';
                            }
                        }
                    } else {
                        if ($since_start->h == 1) {
                            $result = $since_start->h . ' hour';
                        } else {
                            $result = $since_start->h . ' hours';
                        }
                    }
                } else {
                    if ($since_start->d == 1) {
                        $result = $since_start->d . ' day';
                    } else {
                        $result = $since_start->d . ' days';
                    }
                }
            } else {
                if ($since_start->m == 1) {
                    $result = $since_start->m . ' month';
                } else {
                    $result = $since_start->m . ' months';
                }
            }
        } else {
            if ($since_start->y == 1) {
                $result = $since_start->y . ' year';
            } else {
                $result = $since_start->y . ' years';
            }
        }
 
        return  $result ." ago" ;
    }
}

