<?php
    include_once '../../models/Quote.php';
    class Update{
        public function __construct(private Quote $gateway){

        }
        public function update($data){

            
            if($this->gateway->update($data)){                
                echo json_encode(array('message' => 'Quote Updated'));
                }else {
                    echo json_encode(array('message' => 'quote_id Not Found'));
                }

        }

    }


?>