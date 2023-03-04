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
   
    
    
    switch ($method){
        case "GET":
            if(isset($_GET['id']) ){
                $id = 'q.id = ' . $_GET['id'];
                
                processRequest($_SERVER["REQUEST_METHOD"], $id, NULL);
            }elseif(isset($_GET['authorId']) && isset($_GET['categoryId'])) {
                $id = 'q.author_id = ' . $_GET['authorId'] . ' AND q.category_id = ' .
                $_GET['categoryId'];
                
                processRequest($_SERVER["REQUEST_METHOD"], $id, NULL);
            }elseif(isset($_GET['authorId'])) {
                $id = 'q.author_id = ' . $_GET['authorId'];
                               
                processRequest($_SERVER["REQUEST_METHOD"], $id, NULL);
            }elseif(isset($_GET['categoryId'])){
                $id = 'q.category_id = ' . $_GET['categoryId'];
                              
                processRequest($_SERVER["REQUEST_METHOD"], $id, NULL);
            }else{
                $id = null;
                processRequest($_SERVER["REQUEST_METHOD"], $id, NULL);
            }
            break;
        case "POST":
            processRequest($_SERVER["REQUEST_METHOD"], NULL, NULL);      
            break;
        case "PUT":
            $quote = null;
            $id = null;
            processSingle($_SERVER["REQUEST_METHOD"], $id, $quote);
            break;
        case "DELETE":
            $quote = null;
            $id = null;
            processSingle($_SERVER["REQUEST_METHOD"], $id, $quote);
            break;


    }
    
    
    
    
       

    function processRequest(string $method, ?string $id, ?string $quote): void
        {
            if ($id) {
                
                processSingle($method, $id, $quote);
                //echo "ids";
                
            } else {

                processAll($method, $quote);
                
                //$controller->allRequest($method);
                
            }
        }

    function processAll($method, $quote){
        $database = new Database();
        $gateway = new Quote($database);
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
    function processSingle($method, $id, $quote){
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
                if(!$data) {
                    echo json_encode(["message" => 'Missing Required Parameters']);
                    break;
                }
                $controller->update($data);
                break;
            case "DELETE":
                $controller = new Delete($gateway);
                $data = (array) json_decode(file_get_contents("php://input"));
                if(!$data) {
                    echo json_encode(["message" => 'Missing Required Parameters']);
                    break;
                }
                $controller->delete($data);
                break;

        }


    }


?>