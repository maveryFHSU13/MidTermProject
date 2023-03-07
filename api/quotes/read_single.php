<?php

include_once '../../models/Quote.php';

    class Read_Single{
        public function __construct(private Quote $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                
                echo json_encode(['message' => 'No Quotes Found']);
                exit;
            }else {

                $quote_arr = array();
                
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  
                  array_push($quote_arr, ['id'=>$id, 'quote'=>$quote, 'author'=>$author, 'category'=>$category]);
                }
          
                // Turn to JSON & output
                echo json_encode($quote_arr);
            }

            
        }
    }
?>