<?php
//*****************************************************
//
// This class provides a wrapper for the database 
// All methods work on the patients table

class patientDB
{
    // This data field represents the database
    private $patientData;

    //*****************************************************
    // patients class constructor:
    // Instantiates a PDO object based on given URL and
    // uses that to initialize the data field $patientData
    //
    // INPUT: URL of database configuration file
    // Throws exception if database access fails
    // ** This constructor is very generic and can be used to 
    // ** access your course database for any assignment
    // ** The methods need to be changed to hit the correct table(s)
    public function __construct($configFile) 
    {
        // Parse config file, throw exception if it fails
        if ($ini = parse_ini_file($configFile))
        {
            // Create PHP Database Object
            $connectionString = "mysql:host=" . $ini['servername'] . 
            ";port=" . $ini['port'] . 
            ";dbname=" . $ini['dbname'];

            $patientPDO = new PDO( $connectionString, 
                                $ini['username'], 
                                $ini['password']);

            // Don't emulate (pre-compile) prepare statements
            $patientPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Throw exceptions if there is a database error
            $patientPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Set our database to be the newly created PDO
            $this->patientData = $patientPDO;
        }
        else
        {
            // Things didn't go well, throw exception!
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }

    } // end constructor

// Database access & modify methods are listed below. 
// General structure of each method is:
//  1) Set up variable for database and query results
//  2) Set up SQL statement (with parameters, if needed)
//  3) Bind any parameters to values
//  4) Execute statement and check for returned rows
//  5) Return results if needed.

    //*****************************************************
    // Get listing of all patients
    // INPUT: None
    // RETURNS: Array with each entry representing a row in the table
    //          If no records in table, array is empty
    public function getpatients() 
    {
        $results = [];                  // Array to hold results
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query
        $stmt = $patientTable->prepare("SELECT * FROM patients ORDER BY patientLastName"); 
        
        // Execute query and check to see if rows were returned
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
            // if successful, grab all rows
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);                 
        }         

        // Return results to client
        return $results;
    }

    //*****************************************************
    // Add a patient to database
    // INPUT: patient and divison to add
    // RETURNS: True if add is successful, false otherwise
    public function addpatient($firstname, $lastname, $birthdate, $married) 
    {
        $addSucessful = false;         // patient not added at this point
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query with parameters for patient and division
        $stmt = $patientTable->prepare("INSERT INTO patients SET patientFirstName = :fnameParam, patientLastName = :lnameParam, patientMarried = :marryParam, patientBirthDate = :dobParam");

        // Bind query parameters to method parameter values
        $boundParams = array(
            ":fnameParam" => $firstname,
            ":lnameParam" => $lastname,
            ":dobParam" => $birthdate,
            ":marryParam" => $married,
        );       
        
         // Execute query and check to see if rows were returned 
         // If so, the patient was successfully added
        $addSucessful = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);
        
         // Return status to client
         return $addSucessful;
    }
   
    //*****************************************************
     //*****************************************************
    // Add a patient to database
    //   Uses alternative style to bind query parameters.
    // INPUT: patient and divison to add
    // RETURNS: True if add is successful, false otherwise
    public function addpatient2($patient, $division) 
    {
        $addSucessful = false;         // patient not added at this point
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query with parameters for patient and division
        $stmt = $patientTable->prepare("INSERT INTO patients SET  patientFirstName = :fnameParam, patientLastName = :lnameParam, patientMarried = :marryParam, patientBirthDate = :dobParam");

        // Bind query parameters to method parameter values
        $stmt->bindValue(':patientParam', $patient);
        $stmt->bindValue(':divisionParam', $division);
       
        // Execute query and check to see if rows were returned 
        // If so, the patient was successfully added
         $addSucessful = ($stmt->execute() && $stmt->rowCount() > 0);
        
         // Return status to client
         return $addSucessful;
    }

    //*****************************************************
    // Update specified patient with a new name and division
    // INPUT: id of patient to update
    //        new value for patient name
    //        new value for division
    // RETURNS: True if update is successful, false otherwise
    public function updatepatient ($id,$fnameParam, $lnameParam, $dobParam, $marryParam) 
    {
        $updateSucessful = false;        // patient not updated at this point
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query with parameters for patient and division
        //    id is used to ensure we update correct record
        $stmt = $patientTable->prepare("UPDATE patients SET patientFirstName = :fnameParam, patientLastName = :lnameParam, patientMarried = :marryParam, patientBirthDate = :dobParam WHERE id = :idParam");
        
         // query parameters --> method parameter
        $stmt->bindValue(':idParam', $id);
        $stmt->bindValue(':fnameParam', $fnameParam);
        $stmt->bindValue(':lnameParam', $lnameParam);
        $stmt->bindValue(':dobParam', $dobParam);
        $stmt->bindValue(':marryParam', $marryParam);

        // Execute query and check to see if rows were returned 
        // If so, the patient was successfully updated      
        $updateSucessful = ($stmt->execute() && $stmt->rowCount() > 0);

          // Return status to client
          return $updateSucessful;
    }

    //*****************************************************
    // Delete specified patient from table
    // INPUT: id of patient to delete
    // RETURNS: True if update is successful, false otherwise
    public function deletepatient ($id) 
    {
        $deleteSucessful = false;       // patient not updated at this point
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we delete correct record
        $stmt = $patientTable->prepare("DELETE FROM patients WHERE id=:idParam");
        
         // Bind query parameter to method parameter value
        $stmt->bindValue(':idParam', $id);
            
        // Execute query and check to see if rows were returned 
        // If so, the patient was successfully deleted      
        $deleteSucessful = ($stmt->execute() && $stmt->rowCount() > 0);

        // Return status to client           
        return $deleteSucessful;
    }
 
    //*****************************************************
    // Get one patient and place it into an associative array
    public function getpatient ($id) 
    {
        $results = [];                  // Array to hold results
        $patientTable = $this->patientData;   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we delete correct record
        $stmt = $patientTable->prepare("SELECT * FROM patients WHERE id=:idParam");

         // Bind query parameter to method parameter value
         $stmt->bindValue(':idParam', $id);
       
         // Execute query and check to see if rows were returned 
         if ( $stmt->execute() && $stmt->rowCount() > 0 ) 
         {
            // if successful, grab the first row returned
            $results = $stmt->fetch();                       
        }

        // Return results to client
        return $results;
    }

    public function getDatabaseRef()
    {
        return $this->patientData;
    }

    // Destructor to clean up any memory allocation
   public function __destruct() 
   {
       // Mark the PDO for deletion
       $this->patientData = null;

        // If we had a datafield that was a fileReference
        // we should ensure the file is closed
   }

 
} // end class patients
?>