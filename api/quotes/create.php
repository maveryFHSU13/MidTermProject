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
           
            if(!array_key_exists('quote', $quote) || 
            !array_key_exists('author_id', $quote) || 
            !array_key_exists('category_id', $quote) ||
            $quote['quote']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            
            $results = $this->gateway->create($quote);
            if($results == 1){
                $noCategory = ["message" => 'category_id Not Found'];
                echo json_encode($noCategory);
            }elseif($results == 2){
                $noAuthor = ["message" => 'author_id Not Found'];
                echo json_encode($noAuthor);
            }elseif($results){
                $idrecord = $results->fetch(PDO::FETCH_ASSOC);
                echo json_encode($idrecord);
            }
            else{
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            

           

        }
        



    }

?>