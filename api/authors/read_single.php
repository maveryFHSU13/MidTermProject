<?php

include_once '../../models/Author.php';

    class Read_Single{
        public function __construct(private Author $gateway){

        }
        public function singleRequest($method, $id){
            $results = $this->gateway->read_single($id);
            
            if($results->rowCount() == 0){
                http_response_code(404);
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }else {

                $author_arr = array();
                //$author_arr['data'] = array();
          
                while($row = $results->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $author_arr = array(
                    'id' => $id,
                    'author' => $author
                
                  );
                  
                }
          
                // Turn to JSON & output
                echo json_encode($author_arr);
            }

            
        }
    }
?>