<?php
//Create Author class - this will act as the gateway for all queries
    class Author {
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;

        public function __construct($database){
            $this->conn = $database->connect();
        }

        public function getAll(){
            //create query for all records
            $queryAll = 'SELECT * FROM ' . $this->table . ' ORDER BY id';
            //prepare query
            $stmt = $this->conn->prepare($queryAll);
            //execute query
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }         

        }
        public function read_single($id){
            //query for single read
            $querySingle = 'SELECT * FROM ' . $this->table . '
            WHERE id = :id 
            LIMIT 1';
            $stmt = $this->conn->prepare($querySingle);
            //bind a value for id
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            //execute/try query
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }

        }

        public function create($data) {
            //query for POST, create
            $createQuery = ' INSERT INTO ' . $this->table . '
            (id, author) VALUES 
            ((SELECT setval(\'authors_id_seq\', 
            (SELECT MAX(id) FROM authors)+1)), :author) RETURNING id::text, author';

            $stmt = $this->conn->prepare($createQuery);
            //bind a value to author
            $stmt->bindValue(":author", $data["author"], PDO::PARAM_STR);
           

            //execute 
            try {
                $stmt->execute();
                return $stmt;
                    
            }catch(PDOException $e){
                return false;

            }
            
        }
        public function update($data){
            //query for PUT, update
            $updateQuery = 'UPDATE ' . $this->table . '
            SET author = :author 
            WHERE id = :id RETURNING id, author';

            $stmt = $this->conn->prepare($updateQuery);
            //bind values for each author and id
            $stmt->bindValue(":author", $data["author"], PDO::PARAM_STR);
            $stmt->bindValue(":id", $data["id"], PDO::PARAM_INT);

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
        public function delete($data){
            //query for DELETE
            $deleteQuery = 'DELETE FROM ' . $this->table . '
            WHERE id = :id RETURNING id';

            $stmt = $this->conn->prepare($deleteQuery);
            //bind id value
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