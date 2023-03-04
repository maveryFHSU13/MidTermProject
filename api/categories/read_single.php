<?php

include_once '../../models/Category.php';

    class Read_Single{
        public function __construct(private Category $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                http_response_code(404);
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }else {

                $category_arr = array();
                //$category_arr['data'] = array();
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
          
                  $category_item = array(
                    'id' => $id,
                    'category' => $category
                  );
          
                  // Push to "data"
                  array_push($category_arr, $category_item);
                }
          
                // Turn to JSON & output
                echo json_encode($category_arr);
            }

            
        }
    }
?>