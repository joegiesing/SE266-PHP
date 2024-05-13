<?php
 
  // This code runs everything the page loads
  include_once __DIR__ . '/patientDB.php';
  
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
   
  // If it is a GET, we are coming from view.php
  // let's figure out if we're doing update or add
  if (isset($_GET['action'])) 
  {
      $action = filter_input(INPUT_GET, 'action');
      $id = filter_input(INPUT_GET, 'patientId' );
      if ($action == "Update") 
      {
          $row = $patientDatabase->getpatient($id);
          $fnameParam = $row['patientFirstName'];
          $lnameParam = $row['patientLastName'];
          $dobParam = $row['patientBirthDate'];
          $marryParam = $row['patientMarried'];
      } 
      //else it is Add and the user will enter patient & dvision
      else 
      {
        $fnameParam = '';
        $lnameParam = '';
        $dobParam = (new DateTime('now'))->format("m/d/y)");
        $marryParam = 0;
      }
  } // end if GET

  // If it is a POST, we are coming from updatepatient.php
  // we need to determine action, then return to view.php
  elseif (isset($_POST['action'])) {
      $action = filter_input(INPUT_POST, 'action');
      $id = filter_input(INPUT_POST, 'patientId');

      $fnameParam = filter_input(INPUT_POST, 'fnameParam');

      $lnameParam = filter_input(INPUT_POST, 'lnameParam');  

      $dobParam = filter_input(INPUT_POST, 'dobParam');
      $marryParam = 0;

      if (isset($_POST['marryParam'])){
        $marryParam = 1;
      }
      
      if ($action == "Add") {
          $result = $patientDatabase->addPatient ($fnameParam, $lnameParam, $dobParam, $marryParam);
      } 
      elseif ($action == "Update") {
          $result = $patientDatabase->updatePatient ($id, $fnameParam, $lnameParam, $dobParam, $marryParam);
      }

      // send to view.php
      header('Location: viewPatient.php');
  } // end if POST

  // If it is neither POST nor GET, we go to view.php
  // This page should not be loaded directly
  else
  {
    header('Location: viewPatient.php');  
  }
      
?>