<?php
    include_once '../../models/Author.php';
    //Gateway is the Author.php - for all queries
    //this is controller for error checking and response back to client
    class Update{
        public function __construct(private Author $gateway){

        }
        public function update($data){
            //error check  there is data in the array, items are not missing return error

            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('author', $data) || $data['author']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            
            //get array data
            $results = $this->gateway->update($data);
            //if false return error and exit
            if(!$results){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }
            //create array by fetch and send it to client.
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            echo json_encode($idrecord);

        }

    }

   
?>