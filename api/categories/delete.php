<?php
    include_once '../../models/Category.php';
    //Gateway is the Category.php - for all queries
    //this is controller for error checking and response back to client
    class Delete{
        public function __construct(private Category $gateway){

        }
        public function delete($data){
            //run the create with data passed from index.php
           //check for appropriate information in the $data array
            if(!array_key_exists('id', $data) || $data['id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            //get data results from query 
            $results = $this->gateway->delete($data);
            //did result return any records if not return no id found and exit
            if($results == false){
                $noRecords = ["message" => 'category_id Not Found'];
                echo json_encode($noRecords);
                exit;
            }
            //create array from fetch
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //array to object
            $objReturn = json_encode($idrecord);
            //return to client
            echo $objReturn;

        }

    }
    exit();//exit out to prevent multiple attempts


?>