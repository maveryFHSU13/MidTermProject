<?php

include_once '../../models/Quote.php';
//Gateway is the Quote.php - for all queries
    //this is controller for error checking and response back to client

    class Read_Single{
        public function __construct(private Quote $gateway){

        }
        public function singleRequest($method, $id){

            //get query restuls
            $results = $this->gateway->read_single($id);
            //no records return error
            if($results->rowCount() == 0){
                $noRecords = ["message" => 'No Quotes Found'];
                echo json_encode($noRecords);
                exit;
            }else {
                //create array to push
                $quote_arr = array();
                
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    //only 1 results push for an object
                    if($results->rowCount() == 1){
                        $quote_arr = array(
                            'id'=>$id,
                            'quote'=>$quote, 
                            'author'=>$author, 
                            'category'=>$category
                        );
                    }else{    //else push in array               
                        array_push($quote_arr, ['id'=>$id, 'quote'=>$quote,
                        'author'=>$author, 'category'=>$category]);
                    }
                }
          
                // Turn to JSON & output
                echo json_encode($quote_arr);
            }

            
        }
    }
    exit();  //exit out to prevent multiple attempts
?>