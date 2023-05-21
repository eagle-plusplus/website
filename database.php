<?php
    // Database connection configuration
    $db_server = "localhost";  // Database server
    $db_user = "root";  // Database username
    $db_pass = "";  // Database password
    $db_name = "ionio_website";  // Database name
    $conn = "";  // Variable to hold the database connection

    try {
        // Attempt to establish a connection to the database
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } catch(mysqli_sql_exception) {
        // If an exception occurs during the connection attempt, display an error message
        echo "Could not connect!";
    }
?>
