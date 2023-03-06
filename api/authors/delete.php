<?php
    include_once '../../models/Author.php';
    class Delete{
        public function __construct(private Author $gateway){

        }
        public function delete($data){

            if(!array_key_exists('id', $data)){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            if($this->gateway->delete($data)){                
                echo json_encode(array('message' => 'Author Deleted'));
                }else {
                    echo json_encode(array('message' => 'author_id Not Found'));
                }

        }

    }


?>