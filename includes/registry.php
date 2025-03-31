<?php
session_start();
require 'dbconn.php'; // Database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $sex = trim($_POST["sex"]);

    // Ensure all fields are filled
    if (empty($username) || empty($password) || empty($email) || empty($firstname) || empty($lastname) || empty($sex)) {
        die("Error: All fields are required.");
    }

    // Check if username exists
    $stmt = $conn->prepare("SELECT username FROM tbl_players WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die("Error: Username already exists.");
    }
    $stmt->close();

    // ✅ Remove password hashing (store as plain text)
    $sql = "INSERT INTO tbl_players (username, password, email, firstname, lastname, sex, usertype, newscore, oldscore) 
            VALUES (?, ?, ?, ?, ?, ?, 'player', 0, 0)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $password, $email, $firstname, $lastname, $sex);

    if ($stmt->execute()) {
        echo "Success: Account created!";
        header("Location: home.php"); // Redirect to home after successful registration
        exit;
    } else {
        die("Error inserting data: " . $stmt->error);
    }
    error_log(print_r($_POST, true));
    $stmt->close();
}
?>
