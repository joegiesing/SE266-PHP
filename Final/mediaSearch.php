<?php
    include_once __DIR__ . "/controllers/header.php";
    include_once __DIR__ . "/models/mediaDB.php";
    include_once __DIR__ . "/controllers/functions.php";
    
    if (!isUserLoggedIn()) 
    { 
        header ("Location: login.php");
    } 

    
   
    $title = "";
    $category = "";
    $dateAdded = "";


    if (isPostRequest()) 
    {
        $title = filter_input(INPUT_POST, 'mediaTitle');
        $category = filter_input(INPUT_POST, 'mediaCategory');
        $dateAdded = filter_input(INPUT_POST, 'dateAdded');

    }

    $test = new MediaDB("models\dbconfig.ini");
    $media = $test->getSelectedMedia($title, $category, $dateAdded);
    //$media = $test->getAllMedia();

?>
    <div style="display:flex; flex-direction: column; align-items: center; background-color: lightgray; padding: 30px">
        <h2>Search Media</h2>
        <form method="post" action="mediaSearch.php">
            <div class="rowContainer">
                <div class="col1">Title:</div>
                <div class="col2"><input type="text" name="title" value="<?php echo $title; ?>"></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Category:</div>
                <div class="col2"><input type="text" name="category" value="<?php echo $category; ?>"></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Date Added:</div>
                <div class="col2"><input type="text" name="date Added" value="<?php echo $dateAdded; ?>"></div> 
            </div>
                <div class="rowContainer">
                <div class="col1">&nbsp;</div>
                <div class="col2"><input type="submit" name="search" value="Search" class="btn btn-warning"></div> 
            </div>
        </form>
                <table class='table table-striped'>
                    <thead>

                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($media as $row):?>
                            <tr>
                                <td><?= $row['mediaTitle'] ?></td>
                                <td><?= $row['mediaCategory'] ?></td>
                                <td><?= $row['dateAdded'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
    </div>
    <?php

        

    ?>


    <?php
        
        include_once __DIR__ . "/controllers/footer.php";
    ?>