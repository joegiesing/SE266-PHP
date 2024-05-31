<?php

    include_once __DIR__ . '/functions.php';

    include_once __DIR__ . '/../models/UserDB.php';

    include_once __DIR__ . "/header.php";

    // set logged in to false
    $_SESSION['isLoggedIn'] = false;
    
    // If this is a POST, check to see if user credentials are valid.
    $message = "";
    if (isPostRequest()) 
    {

        // get _POST form fields
        $username = filter_input(INPUT_POST, 'userName');
        $password = filter_input(INPUT_POST, 'password');

        // Set up configuration file and create database
        $configFile = __DIR__ . '/dbconfig.ini';
        try 
        {
            $userDatabase = new UserDB($configFile);
        } 
        catch ( Exception $error ) 
        {
            echo "<h2>" . $error->getMessage() . "</h2>";
        }   
    
        // check user credentials
        if ($userDatabase->validateCredentials($username, $password)) 
        {
            $_SESSION['isLoggedIn'] = true;
            // Redirect
            header ('Location: viewMedia.php');
        } 
        else 
        {
           // Incorrect login
           $message = "invalid Login Credentials";
        }
    }

?>