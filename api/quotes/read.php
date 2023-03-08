<?php
    
    include_once '../../models/Quote.php';
    //Gateway is the Quote.php - for all queries
    //this is controller for error checking and response back to client

    class Read {
        public function __construct(private Quote $gateway){

        }
        
        public function allRequest($method){
          //get query results
            $results = $this->gateway->getAll();
            //get number of rows return
            $num = $results->rowCount();
            
            
            if($num > 0){//create array
                $quote_arr = array();
                
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  // Push to "array"
                  array_push($quote_arr, ['id'=>$id, 'quote'=>$quote, 'author'=>$author, 'category'=>$category]);
                }
          
                // Turn to JSON & output
                echo json_encode($quote_arr);
          
          } else {
                // No quotes
                echo json_encode(
                  array('message' => 'No Quotes Found')
                );
            }
           
        }
    }

    
?>