<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit;
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch matric, name, and role from the users table
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

// Start rendering the HTML table
echo "<table border='1'>";
echo "<tr><th>Matric</th><th>Name</th><th>Role</th><th>Actions</th></tr>";

// Loop through the result set and display each row in the table
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['matric']) . "</td>
            <td>" . htmlspecialchars($row['name']) . "</td>
            <td>" . htmlspecialchars($row['role']) . "</td>
            <td>
                <a href='edit.php?matric=" . urlencode($row['matric']) . "'>Update</a> |
                <a href='delete.php?matric=" . urlencode($row['matric']) . "'>Delete</a>
            </td>
          </tr>";
}
echo "</table>"; // Close the table

// Close the database connection
$conn->close();
?>
 <a href="login.php" style="color: purple; text-decoration: underline;">Logout</a>
