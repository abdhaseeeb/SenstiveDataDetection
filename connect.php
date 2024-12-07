<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'login';
$port = 3307; // Ensure this matches the port MySQL is using

// Include the port in the mysqli constructor
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    echo "Failed to connect to DB: " . $conn->connect_error;
} else {
    echo "Connected successfully";
}

?>
