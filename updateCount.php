<?php
session_start();

// Check if the user is logged in and has a valid session
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    // Include the database connection
    include 'connect.php';

    // Decrease the count by 1
    $sql = "UPDATE membership SET count = count - 1 WHERE users_id = '$userId' AND count > 0";

    if ($conn->query($sql) === TRUE) {
        // Successfully updated the count, return a success response
        echo "Success";
    } else {
        // Error updating the count
        echo "Error: " . $conn->error;
    }
} else {
    // Redirect to login if session is not set
    header("Location: login.php");
    exit();
}
?>
