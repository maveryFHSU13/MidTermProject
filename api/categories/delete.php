<?php
    include_once '../../models/Category.php';
    class Delete{
        public function __construct(private Category $gateway){

        }
        public function delete($data){
            if(!array_key_exists('id', $data) || $data['id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            if($this->gateway->delete($data)){                
                echo json_encode(array('message' => 'Category Deleted'));
                }else {
                    echo json_encode(array('message' => 'category_id Not Found'));
                }

        }

    }


?>