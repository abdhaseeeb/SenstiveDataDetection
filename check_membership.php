// PHP (backend) to check membership count
<?php 
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];

    // Check if email is provided
    if (!isset($email)) {
        echo json_encode(['success' => false, 'message' => 'Email is required']);
        exit;
    }

    // Assuming $conn is your DB connection
    $sql = "SELECT count FROM membership m
            JOIN users u ON m.users_id = u.id
            WHERE u.email = '$email'";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'count' => $row['count']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found or no membership data']);
    }
}

?>