<?php
session_start();
require 'dbconn.php'; // Required for database connection

// update_score.php
if (isset($_POST['score'])) {
    $score = $_POST['score'];
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $guest_id = isset($_POST['guest_id']) ? $_POST['guest_id'] : null;

    if ($username) {
        // Update for logged-in user
        $sql = "UPDATE users SET score = ? WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$score, $username]);
    } elseif ($guest_id) {
        // Update for guest user
        $sql = "SELECT * FROM guest_scores WHERE guest_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$guest_id]);
        $existingScore = $stmt->fetch();

        if ($existingScore) {
            // Update score if guest already has a score
            $sql = "UPDATE guest_scores SET score = ? WHERE guest_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$score, $guest_id]);
        } else {
            // Insert new score for guest if no existing record
            $sql = "INSERT INTO guest_scores (guest_id, score) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$guest_id, $score]);
        }
    }
    echo "Score updated"; // Return success message
}



?>
