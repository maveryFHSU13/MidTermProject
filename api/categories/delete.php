<?php
    include_once '../../models/Category.php';
    class Delete{
        public function __construct(private Category $gateway){

        }
        public function delete($data){

            
            if($this->gateway->delete($data)){                
                echo json_encode(array('message' => 'Category Deleted'));
                }else {
                    echo json_encode(array('message' => 'category_id Not Found'));
                }

        }

    }


?>