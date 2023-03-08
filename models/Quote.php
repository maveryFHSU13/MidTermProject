<?php
    class Quote {
        private $conn;
        private $table = 'quotes';

        private $joinQuery ='SELECT q.id, q.quote, a.author,c.category
        FROM quotes q
        INNER JOIN authors a
        ON q.author_id = a.id
        INNER JOIN categories c
        ON q.category_id = c.id';
        

        public $id;
        public $quote;
        public $author_id;
        public  $category_id;

        public function __construct($database){
            $this->conn = $database->connect();
        }

        public function getAll(){
            //for GET all request 
            $returnAll = $this->joinQuery . ' ORDER BY q.id';
            $stmt = $this->conn->prepare($returnAll);
            //execute query 
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }           

        }
        public function read_single($id){
            //for get single request 
            $querySingle = $this->joinQuery . '
            WHERE ' . $id . ' ORDER BY q.id';
            $stmt = $this->conn->prepare($querySingle);

            //execute query 
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;
            }

        }

        public function create($data) {
            //for create with values of quote, id, cat_id and uthor_id
            $createQuery = ' INSERT INTO ' . $this->table . '
            (id, quote, author_id, category_id) VALUES 
            ((SELECT setval(\'quotes_id_seq\', 
            (SELECT MAX(id) FROM quotes)+1)), :quote, :author_id, :category_id)
            RETURNING id, quote, author_id, category_id';

            $stmt = $this->conn->prepare($createQuery);

            //bind data
            $stmt->bindValue(":quote", $data["quote"], PDO::PARAM_STR);
            $stmt->bindValue(":author_id", $data["author_id"], PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $data["category_id"], PDO::PARAM_INT);
            

            //execute 
            try {
                if($stmt->execute()){
                    return $stmt;
                    
                }
            }catch(PDOException $e){
                //I should use better values to return but stuck with numbers for ease
                if($e->getCode()==='23503') {
                    $str = $e->getMessage();
                    $categoryPattern = '/category_id/';
                    $authorPattern = '/author_id/';
                    if(preg_match($categoryPattern, $str)){
                        return 1;//for category error
                    }
                    else{
                        return 2;//for author id error
                    }
                }
                
            }
        }
        public function update($data){
            //for PUT - update
            $updateQuery = 'UPDATE ' . $this->table . '
            SET quote = :quote,
            author_id = :author_id,
            category_id = :category_id

            WHERE id = :id RETURNING id, quote, author_id, category_id';

            $stmt = $this->conn->prepare($updateQuery);
            //bind values
            $stmt->bindValue(":quote", $data["quote"], PDO::PARAM_STR);
            $stmt->bindValue(":author_id", $data["author_id"], PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $data["category_id"], PDO::PARAM_INT);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            //execute query
            try{                
                if($stmt->execute()){
                    if($stmt->rowCount() === 0){
                        return false;
                    }
                    return $stmt;                
                }
            }catch(PDOException $e){
                //search for forgeing key voliation
                if($e->getCode()==='23503') {
                    $str = $e->getMessage();
                    
                    //I should use better values to return but stuck with numbers for ease
                    $categoryPattern = '/category_id/';
                    $authorPattern = '/author_id/';
                    if(preg_match($categoryPattern, $str)){
                        return 1;//for no category_id
                    }
                    elseif(preg_match($authorPattern, $str)){
                        return 2;//for no author id
                    }else{
                        return 3;//this will be for no ID
                    }
                }
                
            }
            
        }
        public function delete($data){
            $deleteQuery = 'DELETE FROM ' . $this->table . '
            WHERE id = :id RETURNING id';

            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            //execute
            try {
                $stmt->execute();
                if($stmt->rowCount() === 0){
                    return false;
                }
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }

        }
    }

?>