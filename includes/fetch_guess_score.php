<?php
// Fetch the scores from your database
// Assuming $oldscore and $newscore are variables containing your score data
// fetch_guess_score.php
// fetch_guess_score.php
$response = [];

if (isset($_SESSION['username'])) {
    // Fetch score for logged-in user
    $sql = "SELECT score FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['username']]);
    $userScore = $stmt->fetchColumn();
    $response['oldscore'] = $userScore ? $userScore : null;
    $response['newscore'] = $userScore ? $userScore : null;
} elseif (isset($_GET['guest_id'])) {
    // Fetch score for guest user
    $guest_id = $_GET['guest_id'];
    $sql = "SELECT score FROM guest_scores WHERE guest_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$guest_id]);
    $guestScore = $stmt->fetchColumn();
    $response['oldscore'] = $guestScore ? $guestScore : null;
    $response['newscore'] = $guestScore ? $guestScore : null;
}

echo json_encode($response); // Return score data in JSON format

?>
