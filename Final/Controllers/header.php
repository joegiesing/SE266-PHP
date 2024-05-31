<?php
  // include functions
  include_once __DIR__ . '/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project PHP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body style="background-color: gray; display: flex; flex-direction: column; justify-content: space-between;">
  <nav class="navbar navbar-inverse" style="background-color: lightgray; width: 100%">
    <div class="container-fluid">
      <div class="navbar-header">
        <span class="navbar-brand"></span>
      </div>
        <?php
          
          if (isUserLoggedIn()) 
          { ?>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="viewMedia.php" style="color: black">View Media</a></li>
                  <li><a href="logoff.php" style="color: black"><span class="glyphicon glyphicon-log-out" style="color: black"></span> Logout</a></li>
              </ul>
              <?php
          } 
        // end logout code
        ?>
    </div>
  </nav>
  <div class="container">