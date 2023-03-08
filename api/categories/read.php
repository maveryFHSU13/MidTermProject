<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    //Gateway is the Category.php - for all queries
    //this is controller for error checking and response back to client

    class Read {
        public function __construct(private Category $gateway){

        }
        
        public function allRequest($method){
          //get query info
            $results = $this->gateway->getAll();
            //how many results are return
            $num = $results->rowCount();
            
            //create array and push data
            if($num > 0){
                $category_arr = array();
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                
                  // Push to "data"
                  array_push($category_arr, ['id'=>$id, 'category' => $category]);
                }
          
                // Turn to JSON & output
                echo json_encode($category_arr);
          
          } else {
                // No categorys
                echo json_encode(
                  array('message' => 'No Categories Found')
                );
            }
           
        }
    }
    


?>