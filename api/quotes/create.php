<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../models/Quote.php';
    class Create{
        public function __construct(private Quote $gateway){

        }
        public function create($quote){
           
            if(!$quote){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            
            $results = $this->gateway->create($quote);
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            echo json_encode($idrecord);

           

        }
        



    }

?>