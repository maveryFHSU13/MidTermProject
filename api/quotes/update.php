<?php
    include_once '../../models/Quote.php';
    //Gateway is the Quote.php - for all queries
    //this is controller for error checking and response back to client
    class Update{
        public function __construct(private Quote $gateway){

        }
        public function update($data){
            //check if array keys is not missing, or blank, return type of error
            if(!array_key_exists('id', $data) || $data['id']=='' ||
             !array_key_exists('category_id', $data) || $data['category_id']=='' ||
             !array_key_exists('author_id', $data) || $data['author_id']==''){
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

            //get query resutls
            $results = $this->gateway->update($data);
            if($results == 1){//results 1 is no category id found
                echo json_encode(["message" => 'category_id Not Found']);
            }elseif($results == 2){//results 2 no author id found
                echo json_encode(["message" => 'author_id Not Found']);
            }
            elseif(!$results){//if false - no quotes found
                echo json_encode(["message" => 'No Quotes Found']);
            }elseif($results){//return the quotes as on object
                $idrecord = $results->fetch(PDO::FETCH_ASSOC);
                $objReturn = json_encode($idrecord);
                echo $objReturn;
            }
            else{//if all else fails its missing
                echo json_encode(["message" => 'Missing Required Parameters']);
                exit;
            }

        }

    }

    
?>