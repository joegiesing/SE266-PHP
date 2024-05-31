<?php
 
  // This code runs everything the page loads
  include_once __DIR__ . '/../models/mediaDB.php';
  include_once __DIR__ . '/functions.php'; 

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

   
  // If it is a GET, we are coming from view.php
  // let's figure out if we're doing update or add
  //title, url, category, date added, date created, notes
  // ":titleParam" => $title,
  // ":urlParam" => $url,
  // ":catParam" => $category,
  // ":addedParam" => $dateadded,
  // ":createdParam" => $datecreated,
  // ":noteParam" => $notes,
  if (isset($_GET['action'])) 
  {
      $action = filter_input(INPUT_GET, 'action');
      $id = filter_input(INPUT_GET, 'mediaId' );
      if ($action == "Update") 
      {
          $row = $mediaDatabase->getOneMedia($id);
          $titleParam = $row['mediaTitle'];
          $urlParam = $row['mediaURL'];
          $catParam = $row['mediaCategory'];

          $addedParam = $row['dateAdded'];
          //$addedParam = date("Y-m-d H:i:s");

          $createdParam = $row['dateCreated'];
          //$createdParam = date("Y-m-d H:i:s");

          $noteParam = $row['mediaNotes'];
      } 
      //else it is Add and the user will enter info
      else 
      {
        $titleParam = '';
        $urlParam = '';
        $catParam = "";
        $addedParam = (new DateTime('now'))->format("y/m/d");
        $createdParam = (new DateTime())->format("y/m/d");
        $noteParam = "";
      }
  } // end if GET


  // If it is a POST, we are coming from updatemedia.php
  // we need to determine action, then return to view.php
  elseif (isset($_POST['action'])) 
  {
    $action = filter_input(INPUT_POST, 'action');
    $id = filter_input(INPUT_POST, 'mediaId');

    $titleParam = filter_input(INPUT_POST, 'titleParam');

    $urlParam = filter_input(INPUT_POST, 'urlParam');  

    $catParam = filter_input(INPUT_POST, 'catParam');
    
    $addedParam = filter_input(INPUT_POST, 'addedParam');

    $createdParam = filter_input(INPUT_POST, 'createdParam');

    $noteParam = filter_input(INPUT_POST, 'noteParam');
      
    

    if ($action == "Add") 
    {
        $result = $mediaDatabase->addMedia ($titleParam, $urlParam, $catParam, $addedParam, $createdParam, $noteParam);
    } 
    elseif ($action == "Update") 
    {
        $result = $mediaDatabase->updateMedia ($id, $titleParam, $urlParam, $catParam, $addedParam, $createdParam, $noteParam);
    }

    // Redirect to view.php
    header('Location: viewMedia.php');
  } // end if POST

  // If it is neither POST nor GET, we go to view.php
  // This page should not be loaded directly
  else
  {
    header('Location: viewMedia.php');  
  }
      
?>