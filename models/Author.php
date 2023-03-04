<?php
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
            $stmt->execute();
            //return the query.
            return $stmt;            

        }
        public function read_single($id){
            $querySingle = 'SELECT * FROM ' . $this->table . '
            WHERE id = :id 
            LIMIT 1';
            $stmt = $this->conn->prepare($querySingle);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;

        }

        public function create($data) {
            $createQuery = ' INSERT INTO ' . $this->table . '
            (id, author) VALUES 
            ((SELECT setval(\'authors_id_seq\', 
            (SELECT MAX(id) FROM authors)+1)), :author)';

            $stmt = $this->conn->prepare($createQuery);

            //clean data 
            
            $this->author = htmlspecialchars(strip_tags($this->author));

            //bind data
            $stmt->bindValue(":author", $data["author"], PDO::PARAM_STR);
            

            //execute 
            if($stmt->execute()){
                return true;
                
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
        public function update($data){
            $updateQuery = 'UPDATE ' . $this->table . '
            SET author = :author 
            WHERE id = :id';

            $stmt = $this->conn->prepare($updateQuery);
            $this->author = htmlspecialchars(strip_tags($this->author));
            $stmt->bindValue(":author", $data["author"], PDO::PARAM_STR);
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