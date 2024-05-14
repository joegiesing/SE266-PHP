<?php
 
 // This code runs everything the page loads
    include_once __DIR__ . '/updateController.php';
 
?>
   
<html lang="en">
<head>
 <title><?= $action ?>Patient</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
   
<div class="container">
 <p></p>

 <form class="form-horizontal" action="updatePatient.php" method="post">
  <input type="hidden" class="form-control" id="action" name="action" value="<?=$action; ?>"/>
   
    <a href="updatePatient.php?action=Add" id="addPatientBtn" <?php if($action!="Update") {echo 'style="display:none"';} ?>>Add Patient</a>

    <div class="panel panel-primary">

        <div class="panel-heading"><h4><?= $action; ?> Patient</h4></div>

        <p></p>

      <div class="form-group">
        <label class="control-label col-sm-2" for="patient name">First Name:</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="fnameParam" placeholder="Enter Your First Name" name="fnameParam" value="<?= $fnameParam; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Last Name:</label>
        <div class="col-sm-10">          
          <input type="text" class="form-control" id="lnameParam" placeholder="Enter Your Last Name" name="lnameParam" value="<?= $lnameParam; ?>">
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Birthdate:</label>
        <div class="col-sm-10">          
          <input type="date" class="form-control" id="dobParam" placeholder="Enter Your Birthdate" name="dobParam" value="<?php echo date("Y-m-d", strtotime($dobParam));?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Married:</label>
        <div class="col-sm-10">          
          <input type="checkbox" class="form-control" id="marryParam" placeholder="Married?" name="marryParam" 
          <?php 
            if ($marryParam == 1)
            {
              echo "checked = 'checked' ";
            }?>>
        </div>
      </div>

      
      <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default"><?php echo $action; ?> Patient</button>
          
          <button type="submit" class="btn btn-default" id="deleteBtn" <?php if($action!="Update") {echo 'style="display:none"';} ?> >Delete Patient</button>
        </div>

      </div>
      
    </div>

      <p></p>

      <!-- <div class="panel panel-warning">

          <div class="panel-heading"><strong>This is for testing and verification:</strong></div>    
          Action: <input type="text" name="action" value="<?= $action; ?>">
          Patient ID: <input type="text" name="patientId" value="<?= $id; ?>">
      </div> -->

 </form>
 
 <div class="col-sm-offset-2 col-sm-10"><a href="./viewPatient.php">View Patients</a></div>
</div>
</div>

</body>
</html>