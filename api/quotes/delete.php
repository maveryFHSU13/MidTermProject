<?php
    include_once '../../models/Quote.php';
    class Delete{
        public function __construct(private Quote $gateway){

        }
        public function delete($data){

            
            if($this->gateway->delete($data)){                
                echo json_encode(array('message' => 'Quote Deleted'));
                }else {
                    echo json_encode(array('message' => 'quote_id Not Found'));
                }

        }

    }


?>