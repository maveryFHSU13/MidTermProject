<?php

include_once '../../models/Category.php';
    //Gateway is the Category.php - for all queries
    //this is controller for error checking and response back to client

    class Read_Single{
        public function __construct(private Category $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                //if no rows return send error
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }else {

                $category_arr = array();
                //create array
                //add row to new array
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
          
                  $category_arr = array(
                    'id' => $id,
                    'category' => $category
                  );
                           
                }
          
                // Turn to JSON & output
                echo json_encode($category_arr);
            }

            
        }
    }
   
?>