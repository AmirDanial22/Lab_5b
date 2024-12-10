<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the matric is set in the URL
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    
    // Fetch the user details from the database
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric']; // Matric cannot be changed
    $name = $_POST['name'];
    $role = $_POST['role'];

    // SQL query to update user details
    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";
    if ($conn->query($sql) === TRUE) {
        header("Location: display.php"); // Redirect to the display page after update
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form to Edit User -->
<h1 style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">Update User</h1>
<form method="POST">
    Matric: <input type="text" name="matric" value="<?= htmlspecialchars($user['matric']) ?>" readonly><br>
    Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>
    Role:
    <select name="role" required>
        <option value="student" <?= $user['role'] == 'student' ? 'selected' : '' ?>>Student</option>
        <option value="lecturer" <?= $user['role'] == 'lecturer' ? 'selected' : '' ?>>Lecturer</option>
    </select><br>
    <button type="submit">Update</button>
     <!-- Add Cancel link -->
     <a href="display.php" style="color: purple; text-decoration: underline; margin-left: 10px;">Cancel</a>
</form>
