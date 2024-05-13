<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    
</head>
<body>


<?php

    require_once ("./functions.php");

    $feedback = "";
    $fname = "";
    $lname = "";
    $married = "";
    $dob = "";
    $age = "";
    $ft = "";
    $in = "";
    $weight = "";

    if (isset($_POST['submitBtn'])) {


        $fname = filter_input(INPUT_POST, 'fname');
        if ($fname == "") {
            $feedback .= 'You did not enter a First Name!';
            $feedback .= '<br>';
        }
        else{
            $feedback .= $fname;
            $feedback .= '<br>';
        }


        $lname = filter_input(INPUT_POST, 'lname');
        if ($lname == "") {
            $feedback .= 'You did not enter a Last Name!';
            $feedback .= '<br>';
        }
        else{
            $feedback .= $lname;
            $feedback .= '<br>';
        }


        $maried = filter_input(INPUT_POST, 'married', FILTER_VALIDATE_BOOLEAN);
        if ($maried == true) {
            $feedback .= 'Married';
            $feedback .= '<br>';
        }
        else{
            $feedback .= 'Unmaried';
            $feedback .= '<br>';
        }


        $now = time();
        if (strtotime($_POST['dob']) >= $now){
            $feedback .= 'Invalid birth date';
            $feedback .= '<br>';
        }
        else{
            $dob = ($_POST['dob']);

            $feedback .= $dob;
            $feedback .= '<br>';
        }


        $age = age($dob);
        $feedback .= $age;
        $feedback .= '<br>';


        $ft = filter_input(INPUT_POST, 'feet', FILTER_VALIDATE_FLOAT);
        if ($ft < 1 || $ft > 9 ){
            $feedback .= 'feet need to be greater than 1 and less than 9';
            $feedback .= '<br>';                  
        }
        else{
            $feedback .= $ft . " Feet" . "  ";
            //$feedback .= '<br>';
        }


        $in = filter_input(INPUT_POST, 'inch', FILTER_VALIDATE_FLOAT);
        if ($in <= 0 || $in > 12 ){
            $feedback .= 'Inches need to be greater than 0 and less than 12';
            $feedback .= '<br>';                  
        }
        else{
            $feedback .= $in . " Inches";
            $feedback .= '<br>';
        }


        $weight = filter_input(INPUT_POST, 'lbs', FILTER_VALIDATE_FLOAT);
        if ($weight <= 0 || $weight > 400 ){
            $feedback .= 'Weight needs to be greater than 0 and less than 500';
            $feedback .= '<br>';                  
        }
        else{
            $feedback .= $weight . " lbs";
            $feedback .= '<br>';
        }

        // function bmi ($ft, $in, $weight) {
        //     return $weight /pow(($ft * 12 + $in),2) * 703;
        // }

    }
    

    
?>


    <h1>Form</h1>
   
    <form method="POST" action="index.php">
        
        <div>
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo $fname?>"/>
            
            <br>

            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo $lname?>"/>
            
            <br>

            <label>Married</label>
            Yes<input type="radio" name="married" value="yes"  <?php if($married == 1) echo 'checked="checked" '?>/>
            No<input type="radio" name="married" value="no"  <?php if($married == 0) echo 'checked="checked" '?>/> 
            
            <br>

            <label>Birth Date</label>
            <input type="date" name="dob" controldate value="<?php echo $dob?>"/>

            <br>

            <label>Height</label>
            <span>feet:</span>
            <input type="number" name="feet" placeholder="0" value="<?php echo $ft?>"/>

            <span>inches:</span>
            <input type="number" name="inch" placeholder="0" value="<?php echo $in?>"/>

            <br>

            <label>Weight</label>
            <input type="number" name="lbs" placeholder="0" value="<?php echo $weight?>"/>

            <br>
            <br>

            <input type="submit" name="submitBtn" value="submit"/>
        </div>
    </form>

    <div>
        <?php echo $feedback ?>
        <?php
            echo 'BMI: ';
            echo round($calc = bmi($ft, $in, $weight), 1);
            if($calc < 18.5){
                echo ' | Underweight';
            }
            else if($calc >= 18.5 && $calc <= 24.9)
            {
                echo ' | Normalweight';
            } 
            else if($calc >= 25.0 && $calc <= 29.9)
            {
                echo ' | Overweight';
            }
            else
            {
                echo ' | Obese';
            }
        ?>
    </div>

</body>
</html>