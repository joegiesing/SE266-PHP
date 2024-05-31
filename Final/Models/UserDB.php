<?php

class UserDB
{
    private $userData;

    // Used to salt user password
    const PASSWORD_SALT = "school-salt";


    //**********************
    // Users class constructor
    public function __construct($configFile) 
    {
        // Parse config file
        if ($ini = parse_ini_file($configFile))
        {
            // Create PHP Database Object
            $userPDO = new PDO( "mysql:host=" . $ini['servername'] . 
                                ";port=" . $ini['port'] . 
                                ";dbname=" . $ini['dbname'], 
                                $ini['username'], 
                                $ini['password']);

            $userPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $userPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Set database to be the newly created PDO
            $this->userData = $userPDO;
        }
        else
        {
            // throw exception
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }

    } // end constructor


    //**********************
    // Get listing of all users
    public function getAllUsers() 
    {
        $results = [];                  // Array
        $userTable = $this->userData;   // Alias for database PDO

        // Return results to client
        return $results;
    }


    //**********************
    // Add a user to database
    public function addUser($user, $password) 
    {
        $addSucessful = false;         
        $userTable = $this->userData;   // Alias for database PDO
        
        $salt = random_bytes(32);

        $stmt = $userTable->prepare("INSERT INTO users SET userName = :user, userPassword = :pwd, userSalt = :salt");

        // Bind query parameters to method parameter values
        $boundParams = array(
            ":user" => $user,
            ":password" => sha1($salt . $password),
            ":salt" => $salt
        );       
        
         // Execute query and check to see if rows were returned 
         // If so, the user was successfully added
        $addSucessful = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);


         // Return status to client
         return $addSucessful;
    }
   

    //**********************    
    // Delete specified user from table
    public function deleteUser ($id) 
    {
        $deleteSucessful = false;       
        $userTable = $this->userData;   // Alias for database PDO

        // Return status to client           
        return $deleteSucessful;
    }
 
    //*****************************************************
    // Get one user and place it into an associative array
    public function getUser($id) 
    {
        $results = [];                  // Array to hold results
        $userTable = $this->userData;   // Alias for database PDO

        // Return results to client
        return $results;
    }


    // Special function accessible to derived classes
    // Allows children to make database queries.
    public function getDatabaseRef()
    {
        return $this->userData;
    }


    //**********************
    // Validates credentials user entered on form
    // INPUT: username and password from login form
    public function validateCredentials($userName, $password)
    {
        $isValidUser = false;
        $userTable = $this->userData;   // Alias for database PDO

        // Create query object with username and password
        // $stmt = $userTable->prepare("SELECT id FROM users WHERE userName =:userName AND userPassword = :password");
        $stmt = $userTable->prepare("SELECT userPassword, userSalt FROM users WHERE userName =:userName");
 
        // Bind query parameter values
        $stmt->bindValue(':userName', $userName);

        $foundUser = ($stmt->execute() && $stmt->rowCount() > 0);

        if ($foundUser)
        {
            //$isValidUser = true;
            $results = $stmt->fetch(PDO::FETCH_ASSOC); 
            $hashedPassword = sha1( $results['userSalt'] . $password);
            $isValidUser = ($hashedPassword == $results['userPassword']);
        }
        // Note that salt is prepended.
        
        //$stmt->bindValue(':password', sha1( self::PASSWORD_SALT . $password));
               
        return $isValidUser;
    }
 
} // end class users
?>