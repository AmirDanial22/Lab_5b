<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve matric number and password from the form
    $matric = $_POST['matric'];
    $password = $_POST['password'];
    
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');
    
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // SQL query to check if the matric number exists
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    // If a matching record is found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true; // Set session to indicate the user is logged in
            $_SESSION['role'] = $user['role']; // Store the user's role
            header("Location: display.php"); // Redirect to the display page
        } else {
            echo "Invalid password!"; // Error for incorrect password
        }
    } else {
        echo "User not found!"; // Error for non-existent user
    }
    
    // Close the database connection
    $conn->close();
}
?>
<!-- HTML form for login -->
<form method="POST">
    Matric: <input type="text" name="matric" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<p>
        <!-- Add the registration link here -->
        <a href="register.php" style="color: purple; text-decoration: underline;">Register</a> here if you have not.
    </p>
