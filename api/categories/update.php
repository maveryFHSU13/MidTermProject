<?php
    include_once '../../models/Category.php';
    //Gateway is the Category.php - for all queries
    //this is controller for error checking and response back to client
    class Update{
        public function __construct(private Category $gateway){

        }
        public function update($data){
            //check to make sure array key and data is not blank, if so exit and report error
            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('category', $data) || $data['category']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            //get query results
            $results = $this->gateway->update($data);
            //if no data found send error message
            if(!$results){
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }
            //put results in array
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //send info to client
            echo json_encode($idrecord);

         
        }

    }
   
?>