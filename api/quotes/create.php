<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../models/Quote.php';
    //Gateway is the Quote.php - for all queries
    //this is controller for error checking and response back to client
    class Create{
        public function __construct(private Quote $gateway){

        }
        public function create($quote){
            //check to see if keys exists if not send error and exit           
            if(!array_key_exists('quote', $quote) || 
            !array_key_exists('author_id', $quote) || 
            !array_key_exists('category_id', $quote) ||
            $quote['quote']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            //get query results
            $results = $this->gateway->create($quote);
            //if results error  of 1 - no category id found
            if($results == 1){
                $noCategory = ["message" => 'category_id Not Found'];
                echo json_encode($noCategory);
            }elseif($results == 2){  //error result 2 = no author id found
                $noAuthor = ["message" => 'author_id Not Found'];
                echo json_encode($noAuthor);
            }elseif($results){ //if true create array and send to client
                $idrecord = $results->fetch(PDO::FETCH_ASSOC);
                echo json_encode($idrecord);
            }
            else{  //all else fails send missing requirement
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
        }
    }

exit();  //exit out to prevent multiple attempts
?>