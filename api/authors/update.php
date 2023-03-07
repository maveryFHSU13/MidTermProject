<?php
    include_once '../../models/Author.php';
    class Update{
        public function __construct(private Author $gateway){

        }
        public function update($data){

            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('author', $data) || $data['author']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }
            
            
            $results = $this->gateway->update($data);
            if(!$results){
                echo json_encode(["message" => 'author_id Not Found']);
                exit;
            }

            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            echo json_encode($idrecord);

        }

    }


?>