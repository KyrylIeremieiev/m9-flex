<?php
require_once __DIR__ . '/config.php';
class API {
    function Submit(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return false;
        }   
            $json = file_get_contents('php://input');
            var_dump($json); die;
            $data = json_decode($json, true);
        
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(401); // Bad Request
                echo json_encode(['error' => 'Invalid JSON']);
                return false;

            } 
                // Process $data as needed
                // ...
        
                // Send a successful response
                header('Content-Type: application/json');
                http_response_code(200); // OK
                echo json_encode(['message' => 'Data processed successfully']);
            
            
             
        }
}

$api = new API;
$api->Submit();

/* header('Content-Type: application/json') */
