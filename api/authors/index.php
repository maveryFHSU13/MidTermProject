<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
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
    //make the database connection
    $database = new Database();
    //create the Author gateway
    $gateway = new Author($database);
    
    //switch for the request method - handles all GET,POST,PUT,DELETE
    //no selection will default to get all request
    switch ($method){
        case "GET":   //if there is an id - get single read else all records
            if(isset($_GET['id']) ){
                $id = $_GET['id'];
                $controller = new Read_Single($gateway);
                $controller->singleRequest($method, $id);   
            }else {
                $controller = new Read($gateway);
                $controller->allRequest($method);
            }
            break;
        case "POST":  //get contents as an array
            $controller = new Create($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->create($data);
            break;
        case "PUT":   //get contents as an array
            $controller = new Update($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->update($data);
            break;
        case "DELETE":  //get contents as an array
            $controller = new Delete($gateway);
            $data = (array) json_decode(file_get_contents("php://input"));
            $controller->delete($data);            
            break;
        default:  //return all for no selection
            $controller = new Read($gateway);
            $controller->allRequest($method);
            break;

    }
    


?>