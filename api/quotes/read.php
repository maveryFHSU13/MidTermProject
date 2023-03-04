<?php
    
    include_once '../../models/Quote.php';

    class Read {
        public function __construct(private Quote $gateway){

        }
        
        public function allRequest($method){
            $results = $this->gateway->getAll();
            
            $num = $results->rowCount();
            
            
            if($num > 0){
                $quote_arr = array();
                $quote_arr['data'] = array();
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
          
                  $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                  );
          
                  // Push to "data"
                  array_push($quote_arr['data'], $quote_item);
                }
          
                // Turn to JSON & output
                echo json_encode($quote_arr);
          
          } else {
                // No quotes
                echo json_encode(
                  array('message' => 'No quotes Found')
                );
            }
           
        }
    }


?>