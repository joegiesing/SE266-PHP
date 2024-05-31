<?php
    
    include_once __DIR__ . '/../models/mediaDB.php';
    include_once __DIR__ . '/functions.php';
    
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
    // If POST, delete the requested media before listing all content
    if (isPostRequest()) {
        $id = filter_input(INPUT_POST, 'mediaId');
        // $id = $_POST['mediaId'];
        $mediaDatabase->deleteMedia($id);

    }
    $mediaListing = $mediaDatabase->getAllMedia();
    