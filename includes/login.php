<?php
session_start();
require 'dbconn.php';

// Get the username and password from the POST request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate that the username and password are not empty
if (empty($username) || empty($password)) {
    echo "Please enter both username and password.";
    exit();
}

// Prepare the SQL statement to check the username and fetch necessary data
$stmt = $conn->prepare("SELECT userid, password, username, oldscore, newscore FROM tbl_players WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Fetch the result and compare passwords
    $stmt->bind_result($userid, $hashedPasswordFromDatabase, $dbUsername, $oldscore, $newscore);
    $stmt->fetch();

    // Compare the entered password to the one in the database
    if ($password === $hashedPasswordFromDatabase) { // Warning: This is insecure. Use hashing in production.
        // Login successful, store the user info in session
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $dbUsername;
        $_SESSION['oldscore'] = $oldscore;
        $_SESSION['newscore'] = $newscore;  // Storing the newscore

        echo "success"; // Return success message
    } else {
        // Incorrect password
        echo "Incorrect username or password";
    }
} else {
    // User not found
    echo "Incorrect username or password";
}

$stmt->close();
?>
