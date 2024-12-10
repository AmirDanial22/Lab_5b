<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $matric = $_POST['matric']; // Matric number
    $name = $_POST['name'];     // User's name
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];     // User's role: student or lecturer
    
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');
    
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert data into the users table
    $sql = "INSERT INTO users (matric, name, password, role) VALUES ('$matric', '$name', '$password', '$role')";
    
    // Execute the query and check if it's successful
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!"; // Success message
    } else {
        echo "Error: " . $conn->error; // Display error if query fails
    }
    
    // Close the database connection
    $conn->close();
}
?>
<!-- HTML form for user registration -->
<form method="POST">
    Matric: <input type="text" name="matric" required><br>
    Name: <input type="text" name="name" required><br>
    Password: <input type="password" name="password" required><br>
    Role:
    <select name="role" required>
        <option value="student">Student</option>
        <option value="lecturer">Lecturer</option>
    </select><br>
    <button type="submit">Register</button>
</form>
