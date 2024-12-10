<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Check if the matric is set in the URL
if (isset($_GET['matric'])) {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');
    
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $matric = $_GET['matric'];
    
    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE matric='$matric'";
    if ($conn->query($sql) === TRUE) {
        header("Location: display.php"); // Redirect to the display page after deletion
    } else {
        echo "Error: " . $conn->error;
    }
    
    $conn->close();
}
?>
