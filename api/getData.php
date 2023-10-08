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
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
            header('Access-Control-Allow-Credentials', 'true');
            http_response_code(200); // OK
            exit();
        }
        
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
                /* header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
                header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST requests
                header("Access-Control-Allow-Headers: Content-Type");
                header("Access-Control-Allow-Origin: http://localhost:5500"); // Replace with your frontend URL
                header("Access-Control-Allow-Origin: http://127.0.0.1:5500/");
                header('Access-Control-Allow-Credentials', 'true'); */
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

                #send mail 
                $mailTo = 'persoon@nieuwsbrief.nl';

                // Define the headers so we can use HTML
                $headers  = "From: afzender@testmail.nl\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                // define the subject
                $subject = 'Voorbeeld test mail';

                // define the html content
                $html = 'hoi tester,<br>' . "\n\r";
                $html .= 'Dit is een voorbeeld mail van mij.<br>' . "\n\r";
                $html .= 'En hier staat een link: <a href="https://www.w3schools.com/php/func_mail_mail.asp">Mail voorbeeld</a><br>' . "\n\r";
                $html .= 'groetjes,<br>' . "\n\r";
                $html .= 'De test mail server';

                // send the mail using php mail 
                $res = mail($mailTo, $subject, $html, $headers);
                       
        }
}

$api = new Data;
$api->getData();

/* header('Content-Type: application/json') */
