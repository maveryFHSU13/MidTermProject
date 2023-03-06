<?php
    class Category {
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

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
            (id, category) VALUES 
            ((SELECT setval(\'categories_id_seq\', 
            (SELECT MAX(id) FROM categories)+1)), :category) RETURNING id, category';

            $stmt = $this->conn->prepare($createQuery);

            //clean data 
            
            $this->category = htmlspecialchars(strip_tags($this->category));

            //bind data
            $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
            

            //execute 
            if($stmt->execute()){
                return $stmt;
                
            }

            //print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
        public function update($data){
            $updateQuery = 'UPDATE ' . $this->table . '
            SET category = :category 
            WHERE id = :id';

            $stmt = $this->conn->prepare($updateQuery);
            $this->category = htmlspecialchars(strip_tags($this->category));
            $stmt->bindValue(":category", $data["category"], PDO::PARAM_STR);
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