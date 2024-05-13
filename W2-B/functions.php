<?php

function age ($bdate) {
    $date = new DateTime($bdate);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
 }
 
 function isDate($dob) {
    $date_arr  = explode('-', $dob);
    return checkdate($date_arr[1], $date_arr[2], $date_arr[0]);
 }
 
 function bmi ($ft, $in, $weight) {
    return $weight/pow(($ft * 12 + $in),2) * 703;
 }
 

?>