<?php
require_once __DIR__ . '/config.php';
class API {
    private $conn;

    function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    function Submit(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return false;
        }   
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
        
            if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(401); // Bad Request
                echo json_encode(['error' => 'Invalid JSON']);
                return false;

            } 
                // Process $data as needed
                // ...
                $email = $data['email'];
                $pass = $data['pass'];
                $sql = "INSERT INTO users (email, pass, active) VALUES ('$email', '$pass', 0)";
                // Send a successful response
                if ($this->conn->query($sql) === TRUE) {
                    // Send a successful response
                    header('Content-Type: application/json');
                    http_response_code(200); // OK
                    echo json_encode(['message' => 'Data processed successfully']);
                } else {
                    // Handle database error
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['error' => 'Database error: ' . $this->conn->error]);
                }

                //second query
                $article = $data['article'];
                $sql = "INSERT INTO subs (email, article) VALUES ('$email', '$article')";
                if ($this->conn->query($sql) === TRUE) {
                    // Send a successful response
                    header('Content-Type: application/json');
                    http_response_code(200); // OK
                    echo json_encode(['message' => 'Data processed successfully']);
                } else {
                    // Handle database error
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['error' => 'Database error: ' . $this->conn->error]);
                }
        
                // Close the database connection
                $this->conn->close();
            
            
             
        }
}

$api = new API;
$api->Submit();

/* header('Content-Type: application/json') */
