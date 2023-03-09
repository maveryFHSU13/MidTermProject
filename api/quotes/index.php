<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once 'read.php';
    include_once 'create.php';
    include_once 'read_single.php';
    include_once 'update.php';
    include_once 'delete.php';
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
   
    $database = new Database();
    $gateway = new Quote($database);

    switch ($method){
        case "GET":  //check what is in the get request - make that part of query
            if(isset($_GET['id']) ){ //for id only
                $id = ' WHERE q.id = ' . $_GET['id'] . ') as quotes';                
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['author_id']) && isset($_GET['category_id']) && isset($_GET['random'])){
                $id = ' WHERE q.author_id = ' . $_GET['author_id'] . ' AND q.category_id = ' .
                $_GET['category_id'] . ') as quotes ORDER BY RANDOM() LIMIT 1';
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);                
            }elseif(isset($_GET['author_id']) && isset($_GET['category_id'])) {
                $id = ' WHERE q.author_id = ' . $_GET['author_id'] . ' AND q.category_id = ' .
                $_GET['category_id'] . ') as quotes
                ORDER BY id';                
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['author_id']) && isset($_GET['random'])){
                $id = ' WHERE q.author_id = ' . $_GET['author_id'] . ') as quotes ORDER BY RANDOM() LIMIT 1';
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['author_id'])) { //for author id only
                $id = ' WHERE q.author_id = ' . $_GET['author_id'] . ') as quotes
                ORDER BY id';                              
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['category_id']) && isset($_GET['random'])){
                $id = ' WHERE q.category_id = ' . $_GET['category_id'] . ') as quotes ORDER BY RANDOM() LIMIT 1';
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['category_id'])){  //for cateogry id only
                $id = ' WHERE q.category_id = ' . $_GET['category_id'] . ') as quotes
                ORDER BY id';                             
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['random'])){
                $id = ') as quotes ORDER BY RANDOM() LIMIT 1';
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }else{  //return all
                $controller = new Read($gateway);
                $controller->allRequest($method);
            }
            
            break; 
            
        case "POST": //get contents as an array
            $controller = new Create($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->create($data);      
            break;
        case "PUT": //get contents as an array           
            $controller = new Update($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->update($data);
            break;
        case "DELETE": //get contents as an array          
            $controller = new Delete($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->delete($data);
            break;

    }
   
    


?>