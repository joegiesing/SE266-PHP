<?php

//Test for POST event
function isPostRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}

// Test to determine if this is a GET event
function isGetRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' && !empty($_GET) );
}

function age ($bdate) {
    $date = new DateTime($bdate);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
}

function isUserLoggedIn()
{
    // Check session staus and start session if not running
    if (session_status() !== PHP_SESSION_ACTIVE) 
    {
        session_start();
    }

    // Check if isLoggedIn is set, then check status
    return (array_key_exists('isLoggedIn', $_SESSION) && ($_SESSION['isLoggedIn']));
}


?>