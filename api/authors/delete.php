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

            
            $results = $this->gateway->delete($data);
            if($results == false){
                $noRecords = ["message" => 'author_id Not Found'];
                echo json_encode($noRecords);
                exit;
            }
            
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            $objReturn = json_encode($idrecord);
            echo $objReturn;

        }

    }


?>