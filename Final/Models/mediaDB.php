<?php

class MediaDB
{
    // This data field represents the database
    private $mediaData;

    
    public function __construct($configFile) 
    {
        // Parse config file, throw exception if it fails
        if ($ini = parse_ini_file($configFile))
        {
            // Create PHP Database Object
            $connectionString = "mysql:host=" . $ini['servername'] . 
            ";port=" . $ini['port'] . 
            ";dbname=" . $ini['dbname'];

            $mediaPDO = new PDO( $connectionString, 
                                $ini['username'], 
                                $ini['password']);

            // Don't emulate (pre-compile) prepare statements
            $mediaPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Throw exceptions if there is a database error
            $mediaPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Set our database to be the newly created PDO
            $this->mediaData = $mediaPDO;
        }
        else
        {
            // Things didn't go well, throw exception!
            throw new Exception( "<h2>Creation of database object failed!</h2>", 0, null );
        }

    } // end constructor



    //*****************************************************
    // Get listing of all media
    
    public function getAllMedia() 
    {
        $results = [];                  // Array to hold results
        $mediaTable = $this->mediaData;   // Alias for database PDO

        // Preparing SQL query
        $stmt = $mediaTable->prepare("SELECT * FROM media ORDER BY mediaTitle"); 
        
        // Execute query and check to see if rows were returned
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) 
        {
            // if successful, grab all rows
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);                 
        }         

        // Return results to client
        return $results;
    }



    //*****************************************************
    // Add a media to database
    public function addMedia($title, $url, $category, $dateadded, $datecreated, $notes) 
    {
        $addSucessful = false;        
        $mediaTable = $this->mediaData;   // Alias for database PDO

        // Preparing SQL query with parameters
        $stmt = $mediaTable->prepare("INSERT INTO media SET mediaTitle = :titleParam, mediaURL = :urlParam, mediaCategory = :catParam, dateAdded = :addedParam, dateCreated = :createdParam, mediaNotes = :noteParam");

        // $dateaddedNew = date("Y-m-d", strtotime($dateadded));
        // $datecreatedNew = date("Y-m-d", strtotime($datecreated));

        // Bind query parameters to method parameter values
        $boundParams = array(
            ":titleParam" => $title,
            ":urlParam" => $url,
            ":catParam" => $category,
            ":addedParam" => $dateadded,
            ":createdParam" => $datecreated,
            ":noteParam" => $notes,
            //  mediaTitle
            //  mediaURL
            //  mediaCategory
            //  dateAdded
            //  dateCreated
            //  mediaNotes
        );       
        
         // Execute query and check to see if rows were returned
        $addSucessful = ($stmt->execute($boundParams) && $stmt->rowCount() > 0);
        
         // Return status to client
         return $addSucessful;
    }



    //*****************************************************
    // Update specified media
    // RETURNS: True if update is successful, false otherwise
    public function updateMedia ($id, $title, $url, $category, $dateadded, $datecreated, $notes) 
    {
        $updateSucessful = false;        
        $mediaTable = $this->mediaData;   // Alias for database PDO

        // Preparing SQL query with parameters
        //    id is used to ensure we update correct record
        $stmt = $mediaTable->prepare("UPDATE media SET mediaTitle = :titleParam, mediaURL = :urlParam, mediaCategory = :catParam, dateAdded = :addedParam, dateCreated = :createdParam, mediaNotes = :noteParam WHERE id = :idParam");
        
        // $dateaddedNew = date("Y-m-d", strtotime($dateadded));
        // $datecreatedNew = date("Y-m-d", strtotime($datecreated));

         // Bind query parameters to method parameter values
        $stmt->bindValue(':idParam', $id);
        $stmt->bindValue(':titleParam', $title);
        $stmt->bindValue(':urlParam', $url);
        $stmt->bindValue(':catParam', $category);
        $stmt->bindValue(':addedParam', $dateadded);
        $stmt->bindValue(':createdParam', $datecreated);
        $stmt->bindValue(':noteParam', $notes);

        // Execute query and check to see if rows were returned      
        $updateSucessful = ($stmt->execute() && $stmt->rowCount() > 0);

          // Return status to client
          return $updateSucessful;
    }



    //*****************************************************
    // Delete specified media from table
    public function deleteMedia ($id) 
    {
        $deleteSucessful = false;       
        $mediaTable = $this->mediaData;   // Alias for database PDO

        // Preparing SQL query 
        //    id is used to ensure we delete correct record
        $stmt = $mediaTable->prepare("DELETE FROM media WHERE id=:idParam");
        
         // Bind query parameter to method parameter value
        $stmt->bindValue(':idParam', $id);
            
        // Execute query and check to see if rows were returned      
        // $deleteSucessful = ($stmt->execute() && $stmt->rowCount() > 0);
        $deleteSucessful = ($stmt->execute());

        // Return status to client           
        return $deleteSucessful;
    }
 


    //*****************************************************
    // Get one item and place it into an associative array
    public function getOneMedia ($id) 
    {
        $results = [];                  // Array
        $mediaTable = $this->mediaData;   // Alias for database PDO

        // Preparing SQL query 
        $stmt = $mediaTable->prepare("SELECT * FROM media WHERE id=:idParam");

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



    //*****************************************************
    // Allows user to search for either a media title, category, date or any combination
    public function getSelectedMedia($title, $category, $dateAdded) 
    {
        $results = array();                  
        $binds = array();                    
        $isFirstClause = true;               // Next WHERE clause is first
        $mediaTable = $this->mediaData;   // Alias for database PDO

       // Here is the base SQL statement to select all schools
        $sql = "SELECT id, mediaTitle, mediaCategory, dateAdded FROM media";

        // check for any parameters and build the WHERE clause filters
        // First, title
        if (isset($title)) 
        {
            if ($isFirstClause)
            {
                $sql .= " WHERE ";
                $isFirstClause = false;
            }
            else
            {
                $sql .= " AND ";
            }
            $sql .= " mediaTitle LIKE :mediaTitle";
            $binds['mediaTitle'] = '%'.$title.'%';
        }
      
        // Next, category:
        if (isset($category)) 
        {
            if ($isFirstClause)
            {
                $sql .= " WHERE ";
                $isFirstClause = false;
            }
            else
            {
                $sql .= " AND ";
            }
            $sql .= "  mediaCategory LIKE :mediaCategory";
            $binds['mediaCategory'] = '%'.$category.'%';
        }

        // Finally, date:
        if (isset($dateAdded))
        {
            if ($isFirstClause)
            {
                $sql .= " WHERE ";
                $isFirstClause = false;
            }
            else
            {
                $sql .= " AND ";
            }
           $sql .= "  dateAdded LIKE :dateAdded";
           $binds['dateAdded'] = '%'.$dateAdded.'%';
        }

       // sort whatever records come back
        $sql .= " ORDER BY mediaCategory, mediaTitle";
       
       // Prepare the SQL statement object
        $stmt = $mediaTable->prepare($sql);
      
       // Execute the query and fetch the results into a 
       // table of associative arrays
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Return the results
        return $results;
    }    // end


    public function getDatabaseRef()
    {
        return $this->mediaData;
    }

    // Destructor to clean up any memory allocation
   public function __destruct() 
   {
       // Mark the PDO for deletion
       $this->mediaData = null;

        // fileReference datafield closed
   }

 
} // end class
?>