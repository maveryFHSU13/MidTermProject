<?php

include_once '../../models/Quote.php';

    class Read_Single{
        public function __construct(private Quote $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                http_response_code(404);
                echo json_encode(["message" => 'quote_id Not Found']);
                exit;
            }else {

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
            }

            
        }
    }
?>