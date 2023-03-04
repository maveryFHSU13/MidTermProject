<?php
    include_once '../../models/Author.php';
    class Update{
        public function __construct(private Author $gateway){

        }
        public function update($data){

            
            if($this->gateway->update($data)){                
                echo json_encode(array('message' => 'Author Updated'));
                }else {
                    echo json_encode(array('message' => 'author_id Not Found'));
                }

        }

    }


?>