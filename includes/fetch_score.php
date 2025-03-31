<?php
session_start();
require 'dbconn.php';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    // Fetch the existing scores from the database for the logged-in user
    $stmt = $conn->prepare("SELECT oldscore, newscore FROM tbl_players WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($oldscore, $newscore);
        $stmt->fetch();

        // Return the scores as JSON
        echo json_encode([
            'oldscore' => $oldscore,
            'newscore' => $newscore
        ]);
    } else {
        // No score record found for the user
        echo json_encode([
            'oldscore' => 0,
            'newscore' => 0
        ]);
    }
} else {
    // If the user is not logged in, return default values
    echo json_encode([
        'oldscore' => 0,
        'newscore' => 0
    ]);
}
?>
