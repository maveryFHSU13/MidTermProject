<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    class Read {
        public function __construct(private Category $gateway){

        }
        
        public function allRequest($method){
            $results = $this->gateway->getAll();
            
            $num = $results->rowCount();
            
            
            if($num > 0){
                $category_arr = array();
                //$category_arr['data'] = array();
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  /*
                  $category_item = array(
                    'id' => $id,
                    'category' => $category
                  );
                  */
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