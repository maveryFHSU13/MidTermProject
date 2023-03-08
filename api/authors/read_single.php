<?php

include_once '../../models/Author.php';
    //Gateway is the Author.php - for all queries
    //this is controller for error checking and response back to client
    class Read_Single{
        public function __construct(private Author $gateway){

        }
        public function singleRequest($method, $id){
            //check to verify there is an id
            if($id == ""){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }
            //get query from Author
            $results = $this->gateway->read_single($id);
            //check to see if any results are return, if not , send not found and exit
            if($results->rowCount() == 0){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }else {
                //if there are rows - create an array
                $author_arr = array();
                
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $author_arr = array(
                    'id' => $id,
                    'author' => $author
                
                  );
                  
                }
          
                // Turn to JSON & output
                echo json_encode($author_arr);
            }

            
        }
    }
    
?>