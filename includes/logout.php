<?php
session_start();
session_unset(); // Clear session variables
session_destroy(); // Destroy the session

// Start a new guest session without breaking the flow
session_start();
$_SESSION['usertype'] = 'guest';

// Redirect to home page
header("Location: home.php");
exit();
?>
