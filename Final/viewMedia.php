<?php
    
    
    include_once __DIR__ . '/controllers/listController.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <style type="text/css">
        a:link {text-decoration: none;}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <title>Media View</title>
</head>
<body>
    



    <div class="container" style=" background-color: lightgray; padding: 30px; border: 1px solid black">
        
        <div>
            <div class="col-sm-12">
                <div>
                <h1 style="margin-left: 20px;">Media</h1>
                </div>

            <form action="#" method="post">
                
                <ul>
                    
                    <li>
                        
                        Title <input type="text" name="titleSearch">
                        <br>
                    </li>
                    <li>
                        Category <input type="text" name="categorySearch">
                        <br>
                    </li>
                    <li>
                        Date Added  <input type="datetime" name="dateSearch">
                        <br>
                    </li>
                </ul>
                <br>
                <button type="submit" name="Search" value="Search" class="btn btn-info">Search</button>
            </form>
        </div>
    <hr>
    <br>

    
  <a href="updateMedia.php?action=Add" class="btn btn-info">Add Media</a>


    <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
        
            <?php foreach ($mediaListing as $row): ?>
                <tr>
                    <td style="margin-right:10px">
                        <form action="viewMedia.php" method="post">
                            <input type="hidden" name="mediaId" value="<?= $row['id']; ?>" />
                            <input type="hidden" name="deleteMedia"/>
                            <button class="btn glyphicon glyphicon-trash" type="submit" style="color: red"></button>
                            
                           
              
                        </form>   
                    </td>
                    <td><?php echo $row['mediaTitle']; ?></td>
                    <td><?php echo $row['mediaCategory']; ?> </td>
                    <td><?php echo $row['dateAdded']; ?> </td>
                
                    <td><a href="updateMedia.php?action=Update&mediaId=<?= $row['id'] ?>" class="btn btn-warning">Update</a></td> 
                    
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <br />
        
    </div>
    </div>

    <?php
        include_once __DIR__ . '/controllers/footer.php';
        ?>
</body>
</html>