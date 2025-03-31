<?php
session_start();
require 'dbconn.php'; // Database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess The Word</title>
    <link rel="icon" href="../images/companylogo.png" type="image/png">
    <link rel='stylesheet' href='../css/login.css'>
</head>
<body>
    <form id="registrationForm" method="POST" action="registry.php">
        <div id="loginFormContainer" class="login-form-container">
            <p id="heading">Signup 😱</p>
            <div class="field">
                <input autocomplete="off" name="username" placeholder="Username" class="input-field" type="text" required>
            </div>
            <div class="field">
                <input id="passwordField" name="password" placeholder="Password" class="input-field" type="password" required>
                <svg id="eyeIcon" class="input-icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 3C4.134 3 2 6 2 6s2 3 6 3 6-3 6-3-2-3-6-3z"></path>
                </svg>
            </div>
            <div class="input2">
                <input name="firstname" type="text" class="input-field" placeholder="First Name" required>
                <input name="lastname" type="text" class="input-field" placeholder="Last Name" required>
            </div>
            <div class="field">
                <select name="sex" class="input-field dropdown" required>
                    <option value="" disabled selected>Sex</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="field">
                <input name="email" type="email" class="input-field" placeholder="Email" required>
            </div>
            <div class="btn">
                <button type="submit" id="submitButton" class="button1">Create Account</button>
            </div>
        </div>
    </form>

    <script src="../js/registrationvalidation.js"></script>
</body>
</html>

