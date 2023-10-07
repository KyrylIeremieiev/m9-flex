<?php
require_once __DIR__ . '/config.php';
class Data {
    private $conn;

    function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    function getData(){
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
                $sql = "SELECT * FROM subs WHERE email = '$email'";
                $result = $this->conn->query($sql);
                if ($result->num_rows > 0) {
                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    // Convert data to JSON and echo the response
                    echo json_encode($data);
                } else {
                    // Handle the case where no data is found
                    echo json_encode(['message' => 'No data found']);
                }
                $this->conn->close();
                       
        }
}

$api = new Data;
$api->getData();

/* header('Content-Type: application/json') */
