<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../models/Category.php';
    class Create{
        public function __construct(private Category $gateway){

        }
        public function create($category){
           
            if(!array_key_exists('category', $category) || $category['category']==""){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            $results = $this->gateway->create($category);
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            $objReturn = json_encode($idrecord);
            echo $objReturn;

        }
        



    }

?>