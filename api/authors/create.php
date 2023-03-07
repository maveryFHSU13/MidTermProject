<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    
    include_once '../../models/Author.php';
    class Create{
        public function __construct(private Author $gateway){

        }
        public function create($author){
           
            if(!array_key_exists('author', $author) || $author['author']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            $results = $this->gateway->create($author);
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            $objReturn = json_encode($idrecord);
            echo $objReturn;

        }
        



    }

?>