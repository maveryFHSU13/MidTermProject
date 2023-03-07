<?php
    include_once '../../models/Quote.php';
    class Update{
        public function __construct(private Quote $gateway){

        }
        public function update($data){

            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('category_id', $data) || $data['category_id']=='' ||
             !array_key_exists('author_id', $data) || $data['author_id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            
            $results = $this->gateway->update($data);
            if($results == 1){
                echo json_encode(["message" => 'category_id Not Found']);
            }elseif($results == 2){
                echo json_encode(["message" => 'author_id Not Found']);
            }
            elseif(!$results){
                echo json_encode(["message" => 'No Quotes Found']);
            }elseif($results){
                echo json_encode(array('message' => 'Quote Updated'));
            }
            else{
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

        }

    }


?>