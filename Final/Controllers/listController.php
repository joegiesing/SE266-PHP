<?php

    // Load helper functions (which also starts the session) then check if user is logged in
    include_once __DIR__ . '/functions.php'; 
    include_once __DIR__ . '/../models/mediaDB.php';


    if (!isUserLoggedIn())
    {
        header ('Location: login.php');
    }


    // Set up configuration file and create database
    $configFile = __DIR__ . '/dbconfig.ini';
    try 
    {
        $mediaDatabase = new MediaDB($configFile);
    } 
    catch ( Exception $error ) 
    {
        echo "<h2>" . $error->getMessage() . "</h2>";
    }   


    // If POST, delete the requested media before listing all media
    $mediaListing = [];

    // If POST & SEARCH, only fetch the specified content       
    if (isset($_POST["Search"]))
    {
        $title = $_POST['titleSearch'];
        $category = $_POST['categorySearch'];
        $date = $_POST['dateSearch'];
        
        $mediaListing = $mediaDatabase->getSelectedMedia($title, $category, $date);
    }
    // If POST & DELETE, delete the requested media before fetching all media       
    elseif (isset($_POST["deleteMedia"]))
    {
        $id = filter_input(INPUT_POST, 'mediaId');
        $mediaDatabase->deleteMedia($id);
        $mediaListing = $mediaDatabase->getAllMedia();
    }

    // Else just fetch all
    else
    {
        $mediaListing = $mediaDatabase->getAllMedia();
    }


    // This is a quick sorting hack that does not use
    // either the page form or a database query.
    // It sorts based on the associative array keys.
    $title  = array_column($mediaListing, 'mediaTitle');
    $category = array_column($mediaListing, 'mediaCategory');
    $date = array_column($mediaListing, 'dateAdded');

    array_multisort($title, SORT_ASC, $category, SORT_ASC, $date, $mediaListing);

// Preliminaries are done, load HTML page header
   include_once __DIR__ . "/header.php";

?>