<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['userId'])) {
    echo json_encode(['status' => 'error', 'message' => 'User is not logged in']);
    exit();
}

// Get the POST data (membership type and user ID)
$inputData = json_decode(file_get_contents('php://input'), true);
$userId = $_SESSION['userId']; // Get the user ID from the session
$membershipType = $inputData['membershipType'] ?? '';

// Ensure a valid membership type was passed
if (empty($membershipType)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid membership type']);
    exit();
}

// Include database connection
include 'connect.php';

// Set the membership details based on the selected plan
switch ($membershipType) {
    case 'basic':
        $membershipTypeDb = 'Basic';
        $count = 5; // Example: maximum of 5 images
        break;
    case 'premium':
        $membershipTypeDb = 'Premium';
        $count = 50; // Example: maximum of 50 images
        break;
    case 'premium_plus':
        $membershipTypeDb = 'Premium Plus';
        $count = 9999; // Unlimited images (or some large number)
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid membership type']);
        exit();
}

// Update the membership type and count in the database
$sql = "UPDATE membership SET membership_type = ?, count = ? WHERE users_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $membershipTypeDb, $count, $userId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Membership updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error updating membership: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
