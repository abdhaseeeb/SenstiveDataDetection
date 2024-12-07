<?php
// Define a function to test database connection
function test_db_connection($host_name, $user_name, $user_password, $db_name, $port = 3306) {
    // Create a new connection instance
    $connection = new mysqli($host_name, $user_name, $user_password, $db_name, $port);

    // Check if the connection failed
    if ($connection->connect_error) {
        echo "Failed to connect to the database: " . $connection->connect_error;
    } else {
        // Print successful connection message with server version
        echo "Successfully connected to MySQL Server version " . $connection->server_info . "\n";

        // Execute a query to retrieve the currently selected database
        $query = "SELECT database();";
        $result = $connection->query($query);

        if ($result) {
            // Fetch the result of the query
            $record = $result->fetch_row();
            echo "You're connected to database: " . $record[0] . "\n";
            // Free the memory associated with the result
            $result->free();
        } else {
            // Print an error message if the query failed
            echo "Query failed: " . $connection->error;
        }

        // Close the connection
        $connection->close();
        echo "MySQL connection is closed\n";
    }
}

// Call the function with your database credentials
test_db_connection('localhost', 'root', '', 'login');
?>
