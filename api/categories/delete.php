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

            
            $results = $this->gateway->delete($data);
            if($results == false){
                $noRecords = ["message" => 'category_id Not Found'];
                echo json_encode($noRecords);
                exit;
            }
            
            $idrecord = $results->fetch(PDO::FETCH_ASSOC);
            $objReturn = json_encode($idrecord);
            echo $objReturn;

        }

    }


?>