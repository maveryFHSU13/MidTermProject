<?php
    include_once '../../models/Category.php';
    class Update{
        public function __construct(private Category $gateway){

        }
        public function update($data){

            
            if($this->gateway->update($data)){                
                echo json_encode(array('message' => 'Categories Updated'));
                }else {
                    echo json_encode(array('message' => 'catorgry_id Not Found'));
                }

        }

    }


?>