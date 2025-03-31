<?php
$servername = "localhost"; // Change if using a remote database
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "dbguesstheword"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Secure user input (XSS protection)
function secureInput($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/*
// Password Hashing: For registration or login, hash the password using bcrypt
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
} not used on */

//$conn->close();
?>
