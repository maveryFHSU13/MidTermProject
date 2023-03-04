<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

//    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    class Create{
        public function __construct(private Category $gateway){

        }
        public function create($category){
           
            if(!$category){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            //$data = json_decode(file_get_contents("php://input"));
            
            if($this->gateway->create($category)){                
            echo json_encode(array('message' => 'category Created'));
            }else {
                echo json_encode(array('message' => 'category not created'));
            }

           

        }
        



    }

?>