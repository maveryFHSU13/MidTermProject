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

            $results = $this->gateway->update($data);
            if(!$results){
                echo json_encode(["message" => 'category_id Not Found']);
                exit;
            }

            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            echo json_encode($idrecord);

         
        }

    }


?>