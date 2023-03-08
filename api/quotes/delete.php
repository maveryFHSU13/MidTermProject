<?php
    include_once '../../models/Quote.php';
    //Gateway is the Quote.php - for all queries
    //this is controller for error checking and response back to client
    class Delete{
        public function __construct(private Quote $gateway){

        }
        public function delete($data){
            //check for errors, make sure the id key exists, if not error
            if(!array_key_exists('id', $data)){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            //get query results
            $results = $this->gateway->delete($data);
            //if nothing found return error
            if($results == false){
                $noRecords = ["message" => 'No Quotes Found'];
                echo json_encode($noRecords);
                exit;
            }
            //creat array from fetch
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            //make object from array
            $objReturn = json_encode($idrecord);
            //send info to client
            echo $objReturn;

            

        }

    }

    
?>