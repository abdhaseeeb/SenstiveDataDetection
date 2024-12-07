<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    }
    else{
        // Insert user into 'users' table
        $insertQuery = "INSERT INTO users(firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$password')";
        if($conn->query($insertQuery) === TRUE){
            // Get the last inserted user ID
            $userId = $conn->insert_id;
            
            // Insert membership details for the new user
            $membershipType = 'free';  // Default membership type
            $count = 5;  // Default count

            $insertMembershipQuery = "INSERT INTO membership(users_id, membership_type, count)
                                      VALUES ('$userId', '$membershipType', '$count')";
            if($conn->query($insertMembershipQuery) === TRUE){
                header("location: index.php"); // Redirect after successful registration
            } else {
                echo "Error inserting membership: " . $conn->error;
            }
        } else {
            echo "Error inserting user: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
   $email = $_POST['email'];
   $password = $_POST['password'];
   $password = md5($password);

   // Check user credentials for sign-in
   $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
   $result = $conn->query($sql);
   if($result->num_rows > 0){
        session_start();
        
        $row = $result->fetch_assoc();
        $_SESSION['userId'] = $row['id'];
        $_SESSION['userEmail'] = $row['email'];
        header("Location: detection.php");
        exit();
   } else {
        echo "Not Found, Incorrect Email or Password";
   }
}

?>
