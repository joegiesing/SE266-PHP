<?php
 
 // This code runs everything the page loads
    include_once __DIR__ . '/controllers/updateController.php';
    include_once __DIR__ . '/Controllers/header.php';
 
?>
   

<html lang="en">
<head>
 <title><?= $action ?> Media</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
   
<div class="container">
<a href="./viewMedia.php" class="btn btn-info">Go Back</a>
<!-- <div class="col-sm-offset-2 col-sm-10"><a href="./viewMedia.php">Go Back</a></div> -->
 <p></p>
 
 <form class="form-horizontal" action="updateMedia.php" method="post">
   
 <div class="panel panel-primary" style="background-color: lightgray">
    <div class="panel-heading"><h4><?= $action; ?> Media</h4></div>
    <p></p>
      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Title: </label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="titleParam" placeholder="Enter Title" name="titleParam" value="<?= $titleParam; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">URL: </label>
        <div class="col-sm-10">          
          <input type="text" class="form-control" id="urlParam" placeholder="Enter URL" name="urlParam" value="<?= $urlParam; ?>">
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Category: </label>
        <div class="col-sm-10">          
          <input type="text" class="form-control" id="catParam" placeholder="Enter Category" name="catParam" value="<?= $catParam; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Date Added: </label>
        <div class="col-sm-10">          
          <input type="datetime"  class="form-control" id="addedParam" placeholder="Enter Date Added" name="addedParam" value="<?= $addedParam; ?>">
        </div>
      </div>

      <Div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Date Created: </label>
        <div class="col-sm-10">          
          <input type="datetime" class="form-control" id="createdParam" placeholder="Enter Date Created" name="createdParam" value="<?= $createdParam; ?>">
        </div>
      </div>

      <Div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Notes: </label>
        <div class="col-sm-10">          
          <input type="text" class="form-control" id="noteParam" placeholder="Enter Extra Notes" name="noteParam" value="<?= $noteParam; ?>">
        </div>
      </div>

      

      <div class="form-group">        
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-info"><?php echo $action; ?> Media</button>
        </div>
      </div>
  </div>

   <p></p>
   <div class="panel panel-warning">
   <div class="panel-heading"><strong>This is for testing and verification:</strong></div>    
       Action: <input type="text" name="action" value="<?= $action; ?>">
       Media ID: <input type="text" name="mediaId" value="<?= $id; ?>">
     </div>

 </form>
 
</div>
</div>
  <?php include_once __DIR__ . "/Controllers/footer.php" ?>
</body>
</html>