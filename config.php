<?php
// Database credentials
$servername = "localhost";  // Usually 'localhost' for local development
$username = "root";         // Default username for XAMPP MySQL
$password = "";             // Default password for XAMPP MySQL is empty
$dbname = "garage_db";      // Replace this with your actual database name

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
