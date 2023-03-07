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
            $returnAll = $this->joinQuery . ' ORDER BY q.id';
            $stmt = $this->conn->prepare($returnAll);
            //execute query
            $stmt->execute();
            //return the query.
            return $stmt;            

        }
        public function read_single($id){
            $querySingle = $this->joinQuery . '
            WHERE ' . $id . ' ORDER BY q.id';
            $stmt = $this->conn->prepare($querySingle);

            

            $stmt->execute();

            return $stmt;

        }

        public function create($data) {
            $createQuery = ' INSERT INTO ' . $this->table . '
            (id, quote, author_id, category_id) VALUES 
            ((SELECT setval(\'quotes_id_seq\', 
            (SELECT MAX(id) FROM quotes)+1)), :quote, :author_id, :category_id)
            RETURNING id, quote, author_id, category_id';

            $stmt = $this->conn->prepare($createQuery);

            //clean data 
            
            //$this->quote = htmlspecialchars(strip_tags($this->category));

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
                if($e->getCode()==='23503') {
                    $str = $e->getMessage();
                    $categoryPattern = '/category_id/';
                    $authorPattern = '/author_id/';
                    if(preg_match($categoryPattern, $str)){
                        return 1;
                    }
                    else{
                        return 2;
                    }
                }
                //return false;
            }
        }
        public function update($data){
            $updateQuery = 'UPDATE ' . $this->table . '
            SET quote = :quote,
            author_id = :author_id,
            category_id = :category_id

            WHERE id = :id';

            $stmt = $this->conn->prepare($updateQuery);
            //$this->category = htmlspecialchars(strip_tags($this->category));
            $stmt->bindValue(":quote", $data["quote"], PDO::PARAM_STR);
            $stmt->bindValue(":author_id", $data["author_id"], PDO::PARAM_INT);
            $stmt->bindValue(":category_id", $data["category_id"], PDO::PARAM_INT);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

            try{                
                if($stmt->execute()){
                    if($stmt->rowCount() === 0){
                        return false;
                    }
                    return $stmt;                
                }
            }catch(PDOException $e){
                if($e->getCode()==='23503') {
                    $str = $e->getMessage();
                    echo $str;
                    $categoryPattern = '/category_id/';
                    $authorPattern = '/author_id/';
                    if(preg_match($categoryPattern, $str)){
                        return 1;
                    }
                    elseif(preg_match($authorPattern, $str)){
                        return 2;
                    }else{
                        return 3;
                    }
                }
                
            }
            
        }
        public function delete($data){
            $deleteQuery = 'DELETE FROM ' . $this->table . '
            WHERE id = :id';

            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);
            if($stmt->execute()){
                if($stmt->rowCount() === 0){
                    return false;
                }
                return true;
                
            }
            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;

        }
    }

?>