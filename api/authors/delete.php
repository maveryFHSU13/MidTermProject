<?php
    include_once '../../models/Author.php';
    class Delete{
        public function __construct(private Author $gateway){

        }
        //Gateway is the Author.php - for all queries
        //this is controller for error checking and response back to client
        public function delete($data){
            //check for appropriate information in the $data array
            if(!array_key_exists('id', $data)){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            //get data results from query 
            $results = $this->gateway->delete($data);
            //did result return any records if not return no id found and exit
            if($results == false){
                $noRecords = ["message" => 'author_id Not Found'];
                echo json_encode($noRecords);
                exit;
            }
            //create array from fetch
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //turn it into an obj
            $objReturn = json_encode($idrecord);
            //echo the object.
            echo $objReturn;

        }

    }

    exit();//exit out to prevent multiple attempts
?>