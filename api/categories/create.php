<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    //Gateway is the Category.php - for all queries
    //this is controller for error checking and response back to client
    include_once '../../models/Category.php';
    class Create{
        public function __construct(private Category $gateway){

        }
        public function create($category){
           //run the create with data passed from index.php
           //check for appropriate information in the $data array
            if(!array_key_exists('category', $category) || $category['category']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
             //get the results
            $results = $this->gateway->create($category);
            //create array from fetch
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //change to object from array
            $objReturn = json_encode($idrecord);
            //send info to client
            echo $objReturn;

        }
    }
    exit();  //exit out to prevent multiple attempts

?>