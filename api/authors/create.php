<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    class Create{
        public function __construct(private Author $gateway){

        }
        public function create($author){
           
            if(!$author){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            //$data = json_decode(file_get_contents("php://input"));
            
            $results = $this->gateway->create($author);
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            echo json_encode([$idrecord]);

            /*  
            if($this->gateway->create($author)){ 
                
                               
            echo json_encode(array('message' => 'Author Created'));
            }else {
                echo json_encode(array('message' => 'Author not created'));
            }
            */

           

        }
        



    }

?>