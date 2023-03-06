<?php
    include_once '../../models/Author.php';
    class Update{
        public function __construct(private Author $gateway){

        }
        public function update($data){

            if(!array_key_exists('id', $data) || $data['id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            
            
            if($this->gateway->update($data)){                
                echo json_encode(array('message' => 'Author Updated'));
                }else {
                    echo json_encode(array('message' => 'author_id Not Found'));
                }

        }

    }


?>