<?php
    
    include_once __DIR__ . '/patientDB.php';
    include_once __DIR__ . '/functions.php';
    
    // Set up configuration file and create database
    $configFile = __DIR__ . '/dbconfig.ini';
    try 
    {
        $patientDatabase = new patientDB($configFile);
    } 
    catch ( Exception $error ) 
    {
        echo "<h2>" . $error->getMessage() . "</h2>";
    }   
    // If POST, delete the requested patient before listing all patients
    if (isPostRequest()) {
        
        $id = filter_input(INPUT_POST, 'patientId');
        
        $patientDatabase->deletepatient($id);

    }
    $patientListing = $patientDatabase->getpatients();
?>