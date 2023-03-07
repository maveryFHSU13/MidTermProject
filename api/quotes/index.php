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
        case "GET":
            if(isset($_GET['id']) ){
                $id = 'q.id = ' . $_GET['id'];                
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['author_id']) && isset($_GET['category_id'])) {
                $id = 'q.author_id = ' . $_GET['author_id'] . ' AND q.category_id = ' .
                $_GET['category_id'];                
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['author_id'])) {
                $id = 'q.author_id = ' . $_GET['author_id'];                              
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }elseif(isset($_GET['category_id'])){
                $id = 'q.category_id = ' . $_GET['category_id'];                             
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
            }else{
                $controller = new Read($gateway);
                $controller->allRequest($method);
            }
            break;
        case "POST":
            $controller = new Create($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->create($data);      
            break;
        case "PUT":            
            $controller = new Update($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->update($data);
            break;
        case "DELETE":            
            $controller = new Delete($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->delete($data);
            break;

    }
   
    /*
    function processAll($method){
        
        switch($method){
            case "GET":
                $controller = new Read($gateway);
                $controller->allRequest($method);
                break;
            case "POST":                
                $controller = new Create($gateway);
                $data = (array) json_decode(file_get_contents("php://input"));
                $controller->create($data);
                break;

        }
    }
    function processSingle($method, $id){
        $database = new Database();
        $gateway = new Quote($database);
        switch($method){
            case "GET":
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);
                break;
            case "PUT":
                $controller = new Update($gateway);
                $data = (array) json_decode(file_get_contents("php://input"));
                $controller->update($data);
                break;
            case "DELETE":
                $controller = new Delete($gateway);
                $data = (array) json_decode(file_get_contents("php://input"));
                $controller->delete($data);
                break;

        }


    } */


?>