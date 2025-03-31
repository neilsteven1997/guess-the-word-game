<?php
session_start();
require 'dbconn.php';

// Check if the user is logged in
if (isset($_SESSION['userid'])) {
    // Fetch user details from the session
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'] ?? 'Guest';

    // Initially, the page loads with default values for oldscore and newscore
    $oldscore = 0;
    $newscore = 0;
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess The Word</title>
    <link rel="icon" href="../images/companylogo.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='../js/jquery.zoom.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel='stylesheet' href='../css/style.css'>
</head>
<body>
    
    <div id="loading-screen">
        <div class="loading">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <header class="masthead">
                <div class="container">
                    <h1>Guess the Word</h1>
                    <p>
                        To play, click "Play!" You'll see an image. Guess the word used to search for that image and enter it in the field. Click "Guess." If your guess is incorrect, try again or load more photos for additional clues. Points are deducted for each extra photo loaded or incorrect guess. Hover your mouse over the photo to zoom in. """"Note: Scoring is currently unavailable. We apologize for the inconvenience.""""
                    </p>
                <div class="playercard">
                    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                <p id="highScore">High Score: <?php echo htmlspecialchars($oldscore); ?></p>
                <p id="currentScore">Your Score: <?php echo htmlspecialchars($newscore); ?></p>
                <form action="logout.php" method="POST">
                <button type="submit" class="button load-more-button">Logout</button>
                </form>
                </div>
    <script>
        // Function to fetch the latest score using AJAX
        function fetchScores() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_score.php', true);  // This file will fetch the latest score
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('highScore').innerText = 'High Score: ' + response.oldscore;
                    document.getElementById('currentScore').innerText = 'Your Score: ' + response.newscore;
                } else {
                    console.log('Error fetching score data');
                }
            };
            xhr.send();
        }

        // Fetch the score every 5 seconds
        setInterval(fetchScores, 5000);
    </script>
 
 <?php } else {
    
    $guestUsername = 'Guest';
    $guestOldScore = 0; // Default score for guest
    $guestNewScore = 0; // Static score for guest for testing purposes
    ?>


    <!-- For logged-out users, display the static points or any default score-->
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess The Word</title>
    <link rel="icon" href="../images/companylogo.png" type="image/png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='../js/jquery.zoom.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel='stylesheet' href='../css/style.css'>
</head>
<body>
    
    <div id="loading-screen">
        <div class="loading">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

    <header class="masthead">
                <div class="container">
                    <h1>Guess the Word</h1>
                    <p>
                        To play, click "Play!" You'll see an image. Guess the word used to search for that image and enter it in the field. Click "Guess." If your guess is incorrect, try again or load more photos for additional clues. Points are deducted for each extra photo loaded or incorrect guess. Hover your mouse over the photo to zoom in. PLEASE LOGIN FIRST TO RECORD YOUR SCORE. """"Note: Scoring is currently unavailable. We apologize for the inconvenience.""""
                    </p>
                <div class="playercard">
                    <h2>Welcome, <?php echo htmlspecialchars($guestUsername); ?>!</h2>
                <p id="highScore">High Score: <?php echo htmlspecialchars($guestOldScore); ?></p>
                <p id="currentScore">Your Score: <?php echo htmlspecialchars($guestNewScore); ?></p>
                <form action="../index.php" method="POST">
                <button type="submit" class="login-button">Login</button>
                </form>
                </div>



<?php } ?>
</div>
</header>

    <form id="guess" onsubmit="return false">
        <div class="form-group">
            <div class="messages_container">
            <div><input id="guesses" class= "displaystatusinput" placeholder="" readonly></div>
            <div><input id="number_loaded" class= "displaystatusinput" placeholder="" readonly></div>
            </div>

          <input type="text" name="guess" id="guess_field" placeholder="Press Play To Start"/>
          <br />
          <button class="guess-button" onclick="Check()" id="guess_button">
            Guess 😬
          </button>
          <!--<button class="play-button" onclick="play()">Play 😊</button>-->
          <button class="play-button" onclick="hideButton(); play()">Play 😊</button>
          <button class="give-up-button" onclick="giveUp_function()" id="giveUp">
            Give Up 😭
          </button>
        </div>
      </form>

    <div id="pics" class="bottom">
    <!-- Picture Generator Here-->
    </div>

    <div class="bottom">
        <!--Start Of Audio Control-->
        <label class="slider">
            <input type="range" class="level">
            <svg class="volume" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve">
                <g>
                    <path d="M18.36 19.36a1 1 0 0 1-.705-1.71C19.167 16.148 20 14.142 20 12s-.833-4.148-2.345-5.65a1 1 0 1 1 1.41-1.419C20.958 6.812 22 9.322 22 12s-1.042 5.188-2.935 7.069a.997.997 0 0 1-.705.291z" fill="currentColor" data-original="#000000"></path>
                    <path d="M15.53 16.53a.999.999 0 0 1-.703-1.711C15.572 14.082 16 13.054 16 12s-.428-2.082-1.173-2.819a1 1 0 1 1 1.406-1.422A6 6 0 0 1 18 12a6 6 0 0 1-1.767 4.241.996.996 0 0 1-.703.289zM12 22a1 1 0 0 1-.707-.293L6.586 17H4c-1.103 0-2-.897-2-2V9c0-1.103.897-2 2-2h2.586l4.707-4.707A.998.998 0 0 1 13 3v18a1 1 0 0 1-1 1z" fill="currentColor" data-original="#000000"></path>
                </g>
            </svg>
        </label>    <!--End Of Audio Control-->

        <!-- Start Of Random Audio Song -->
        <audio id="background-audio" loop autoplay></audio>
        <!-- Start Of Audio Controller Function -->
        <script>
        const audioElement = document.getElementById('background-audio');
        const volumeSlider = document.querySelector('.level');

        // Ensure that audioElement and volumeSlider are correctly selected
        if (!audioElement) {
            console.error("Audio element not found!");
        }
        if (!volumeSlider) {
            console.error("Volume slider not found!");
        }

        // Set the initial volume to 50% (or your preferred default)
        audioElement.volume = 0.5;
        volumeSlider.value = 50; // Set slider to match initial volume

        volumeSlider.addEventListener('input', function() {
            const volume = volumeSlider.value; // Get the slider's value (0-100)

            // Normalize the slider value to the audio volume range (0-1)
            audioElement.volume = volume / 100;

            console.log("Volume changed to:", audioElement.volume); // For debugging
        });

        const musicFiles = [
            "../music/Balada Gitana - House of the Gipsies.mp3",
            "../music/Coping Season - The Soundlings.mp3",
            "../music/Forro do Farol - Quincas Moreira.mp3",
            "../music/Mississippi Mover - Everet Almond.mp3"
            // Add paths to all your music files here
        ];

        function playRandomSong() {
            const randomIndex = Math.floor(Math.random() * musicFiles.length);
            audioElement.src = musicFiles[randomIndex];
            audioElement.play(); // Ensure audio starts playing
        }

        // Play a random song when the page loads
        window.addEventListener('DOMContentLoaded', function() {
            playRandomSong();
        });
        </script> <!-- Start Of Audio Controller Function -->
            </div>

            <div class="bottom">
                <button id="showMore" onclick = 'showMore()'
                class="button load-more-button ">
                Load More Photos 🤔
                </button>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
                <br></br>
            </div>

    
    <script>/*This script loads the JS .value to the input buttons for display*/
    const guessesInput = document.getElementById('guesses');
    guessesInput.value = "";
    const numberLoadedInput = document.getElementById('number_loaded');
    numberLoadedInput.value = "";
    </script>



</body>
<script>
$(document).ready(function () {
    // Fetch guest score when the page loads
    $.ajax({
        url: "fetch_guest_score.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
            $("#highScore").text("High Score: " + data.oldscore);
            $("#currentScore").text("Your Score: " + data.newscore);
        }
    });

    // Function to update guest score
    function updateGuestScore(newScore) {
        $.ajax({
            url: "update_guest_score.php",
            method: "POST",
            data: { newscore: newScore },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log("Score updated!");
                    // Refresh scores after update
                    fetchGuestScore();
                } else {
                    console.error("Failed to update score");
                }
            }
        });
    }

    // Function to re-fetch guest score
    function fetchGuestScore() {
        $.ajax({
            url: "fetch_guest_score.php",
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#highScore").text("High Score: " + data.oldscore);
                $("#currentScore").text("Your Score: " + data.newscore);
            }
        });
    }
});

</script>


<script src="../js/word_list.js"></script>
<script src="../js/search_game.js"></script>
</html>