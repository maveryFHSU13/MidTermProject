<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //Gateway is the Author.php - for all queries
    //this is controller for error checking and response back to client
    include_once '../../models/Author.php';
    class Create{
        public function __construct(private Author $gateway){

        }
        //run the create with data passed from index.php
        public function create($data){
           //check for appropriate information in the $data array
            if(!array_key_exists('author', $data) || $data['author']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            //get the results
            $results = $this->gateway->create($data);
            //add results by fetching from pdo
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //since a single create make the array an object
            $objReturn = json_encode($idrecord);
            //return the object
            echo $objReturn;

        }
    }
    exit();//exit out to prevent multiple attempts

?>