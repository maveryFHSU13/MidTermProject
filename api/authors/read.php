<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    class Read {
        public function __construct(private Author $gateway){

        }
        /*
        public function processRequest(string $method, ?string $id): void
        {
            if ($id) {
                
                //$this->processResourceRequest($method, $id);
                echo "ids";
                
            } else {
                
                $this->processAllRequest($method);
                
            }
        }
        */
        public function allRequest($method){
            $results = $this->gateway->getAll();
            //echo json_encode($this->gateway->getAll());
            $num = $results->rowCount();
            
            
            if($num > 0){
                $author_arr = array();
                //$author_arr['data'] = array();
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
          
                  $author_item = array(
                    'id' => $id,
                    'author' => $author
                  );
          
                  // Push to "data"
                  array_push($author_arr, $author_item);
                }
          
                // Turn to JSON & output
                echo json_encode($author_arr);
          
          } else {
                // No Authors
                echo json_encode(
                  array('message' => 'No Authors Found')
                );
            }
           
        }
    }


?>