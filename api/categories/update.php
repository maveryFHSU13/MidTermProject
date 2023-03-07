<?php
    include_once '../../models/Category.php';
    class Update{
        public function __construct(private Category $gateway){

        }
        public function update($data){
            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('category', $data) || $data['category']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            if($this->gateway->update($data)){                
                echo json_encode(array('message' => 'Categories Updated'));
                }else {
                    echo json_encode(array('message' => 'catorgry_id Not Found'));
                }

        }

    }


?>