<?php
    
    include_once '../../models/Author.php';
    //Gateway is the Author.php - for all queries
    //this is controller for error checking and response back to client
    class Read {
        public function __construct(private Author $gateway){

        }
        
        public function allRequest($method){
            //get array from query
            $results = $this->gateway->getAll();
            //how many rows returned
            $num = $results->rowCount();
            
            
            if($num > 0){
                //extract data to new array to output to client
                $author_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                   
                  array_push($author_arr, ['id'=> $id, 'author' => $author]);
          
                  
                }
          
                // Turn to JSON & output
                echo json_encode($author_arr);
          
            } else {
                    // No Authors
                    echo json_encode(
                    array('message' => 'No Authors Found')
                    );
                }
           
        }
    }


?>