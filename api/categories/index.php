<?php
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
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
    
    switch ($method){
        case "GET":
            if(isset($_GET['id']) ){
                $id = $_GET['id'];
                processSingle($method, $id);   
            }else {
                processAll($method);
            }
            break;
        case "POST":
            processAll($method);
        
            break;
        case "PUT":
            $id = null;
            processSingle($_SERVER["REQUEST_METHOD"], $id);
            break;
        case "DELETE":            
            $id = null;
            processSingle($_SERVER["REQUEST_METHOD"], $id);
            break;
    } 
    
    
    
     
    function processAll($method){
        $database = new Database();
        $gateway = new Category($database);
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
        $gateway = new Category($database);
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
    }


?>