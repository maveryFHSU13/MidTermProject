<?php

include_once '../../models/Quote.php';

    class Read_Single{
        public function __construct(private Quote $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                $noRecords = ["message" => 'No Quotes Found'];
                echo json_encode($noRecords);
                exit;
            }else {

                $quote_arr = array();
                
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    if($results->rowCount() == 1){
                        $quote_arr = array(
                            'id'=>$id,
                            'quote'=>$quote, 
                            'author'=>$author, 
                            'category'=>$category
                        );
                    }else{                 
                        array_push($quote_arr, ['id'=>$id, 'quote'=>$quote,
                        'author'=>$author, 'category'=>$category]);
                    }
                }
          
                // Turn to JSON & output
                echo json_encode($quote_arr);
            }

            
        }
    }
?>