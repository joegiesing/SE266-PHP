<?php
    include_once __DIR__ . '/controllers/loginController.php';
?>

<div class="container" style="display:flex; flex-direction: column; align-items: center; background-color: gray; padding: 30px">
    <?php 
        if ($message)
        {   ?>
            <div style="background-color: yellow; padding: 10px; border: solid 1px black;"> 
           <?php echo $message; ?>
           </div>
        <?php } ?>

    <div id="mainDiv" style="display:flex; flex-direction: column; align-items: center; background-color: lightgray; 
        width: 350px; height: 300px; padding: 50px">
        <form method="post" action="login.php">
           
            <div class="rowContainer">
                <h3>Please Login</h3>
            </div>
            <div class="rowContainer">
                <div class="col1">User Name:</div>
                <div class="col2"><input type="text" name="userName" value="donald"></div> 
            </div>
            <div class="rowContainer">
                <div class="col1">Password:</div>
                <div class="col2"><input type="password" name="password" value="duck"></div> 
            </div>
              <div class="rowContainer">
                <div class="col1">&nbsp;</div>
                <div class="col2"><input type="submit" name="login" value="Login" class="btn btn-info"></div> 
            </div>
            
        </form>
        
    </div>
</div>

<?php
    include_once __DIR__ . "/controllers/footer.php";
?>