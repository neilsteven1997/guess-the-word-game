let guesses = 0;
let load_more = 1;
let query;
let input = document.getElementById('guess_field');
input.addEventListener('keydown', function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        document.getElementById('guess_button').click();
    }
})

let key = 'Tzj7yi5_uzA3ueGcm7hcSXaBFqHIy4SbAoUO580ezQo';

function getPics(query, load_more) {
    document.getElementById('guess').elements['guess'].value = '';

    let url = "https://api.unsplash.com/search/photos?query=" +
        query + "&client_id=" + key + "&per_page=50";
    let all_images = '';
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);
            console.log(data)
            for (let i = 0; i < load_more; i++) {
                let img_link = data.results[i].urls.regular;

                let image_text = `<div class='card' id='ex${i}'>
                <img class='card-img-top' src='`+ img_link + "'></div>"

                all_images += image_text
            }
            // console.log(all_images)
            document.getElementById('pics').innerHTML = all_images;
            $(document).ready(function () {
                $('#ex0').zoom()
                $('#ex1').zoom()
                $('#ex2').zoom()
                $('#ex3').zoom()
                $('#ex4').zoom()
                $('#ex5').zoom()
                $('#ex6').zoom()
                $('#ex7').zoom()
                $('#ex8').zoom()
                $('#ex9').zoom()
                $('#ex10').zoom()
                $('#ex11').zoom()
                $('#ex12').zoom()
                $('#ex13').zoom()
                $('#ex14').zoom()
                $('#ex15').zoom()
                $('#ex16').zoom()
                $('#ex17').zoom()
                $('#ex18').zoom()
                $('#ex19').zoom()
                $('#ex20').zoom()
            })
        }
    }

    xhttp.open('GET', url, true);
    xhttp.send();
}
function hideButton() {
  document.querySelector('.play-button').classList.add('hidden');
}
function play() {
    guesses = 0;
    load_more = 1;
    document.getElementById('guesses').value = '';
    document.getElementById('number_loaded').value = '';
    number = Math.floor(Math.random() * 100);
    query = word_list[number];
    console.log(query)
    getPics(query, 1);
    load_more = 1

    document.getElementById('pics').style.justifyContent = 'center';
    document.getElementById('showMore').style.display = 'inline';
    document.getElementById('guess').elements['guess'].setAttribute('placeholder', 'I guess the word is...');
    document.getElementById('guess').elements['guess'].value = '';
    document.getElementById('giveUp').style.display = 'inline';
}
function quit() {
  //console.log("Quit button clicked!");
  document.querySelector('.play-button').classList.remove('hidden'); // Show play button
  // Reset Game State
  guesses = 0;
  load_more = 1;
  number = 0;
  query = "";
  document.getElementById('guesses').value = '';
  document.getElementById('number_loaded').value = '';
  document.getElementById('pics').innerHTML = ""; //clear the picture results.
  document.getElementById('pics').style.justifyContent = '';
  document.getElementById('showMore').style.display = 'none';
  document.getElementById('guess').elements['guess'].setAttribute('placeholder', 'Press Play To Start');
  document.getElementById('guess').elements['guess'].value = '';
  document.getElementById('giveUp').style.display = 'none';
}

function showMore() {
    if (load_more <= 3) { /*adjust here if you want to increase/decrease number of images loaded*/
        load_more += 1;
        getPics(query, load_more);

        document.getElementById('number_loaded').value =
        "Photos Loaded: " + load_more;
        if (load_more > 3) {
            document.getElementById('pics').style.justifyContent = 'flex-start';
        }

    } else {
        return 0;/*alert("Can't load anymore. 🙀")*/
    }
}


// Update score function
// Call this function when the game is over to update the score
function onGameOver(score) {
    updateScore(score); // This will send the score to the server for both guest and logged-in users
}

// Ensure this function is called correctly after the game
function updateScore(score) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../includes/update_score.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    let data;
    const username = document.getElementById('username') ? document.getElementById('username').value : null;

    console.log('Updating score, User:', username ? `Logged-in (${username})` : 'Guest', 'Score:', score);

    if (username) {
        // Update score for logged-in user
        data = `score=${score}&username=${username}`;
    } else {
        // Ensure we are setting a valid guest_id
        let guestId = sessionStorage.getItem('guest_id');
        if (!guestId) {
            guestId = generateGuestId(); // Generate guest ID if not already set
            sessionStorage.setItem('guest_id', guestId); // Save guest ID in sessionStorage
        }
        console.log('Guest ID:', guestId);
        data = `score=${score}&guest_id=${guestId}`;
    }

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Score updated:', xhr.responseText);
            fetchScores(); // Fetch scores after updating
        } else {
            console.log('Error updating score');
        }
    };
    xhr.send(data);
}


// Fetch scores from the database
// Fetch scores from the database
function fetchScores() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../includes/fetch_guess_score.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log('Fetched Scores:', response); // Log the fetched response

            // Handle guest and logged-in users' scores
            if (response.oldscore !== undefined && response.newscore !== undefined) {
                const highScore = response.oldscore !== null ? response.oldscore : "N/A";
                const currentScore = response.newscore !== null ? response.newscore : "N/A";
                document.getElementById('highScore').innerText = `High Score: ${highScore}`;
                document.getElementById('currentScore').innerText = `Your Score: ${currentScore}`;
            } else {
                // Default case if no score is available
                console.log('No score data available');
                document.getElementById('highScore').innerText = `High Score: N/A`;
                document.getElementById('currentScore').innerText = `Your Score: N/A`;
            }
        } else {
            console.log('Error fetching scores');
        }
    };
    xhr.send();
}


// Generate a unique guest ID if not available
function generateGuestId() {
    return 'guest_' + Math.floor(Math.random() * 1000000); // Generate a random guest ID
}



// Start of the game logic where score is updated
function Check() {
    let guess = document.getElementById('guess').elements['guess'].value;
    const lowercaseGuess = guess.toLowerCase();
    
    if (document.getElementById('pics').querySelectorAll('img').length === 0) {
        document.getElementById('guess').elements['guess'].setAttribute('placeholder', 'Click the Play button first!');
    } else if (guess === '') {
        document.getElementById('guess').elements['guess'].setAttribute('placeholder', 'Enter your guess!');
    } else {
        const lowercaseQuery = query.toLowerCase();
    
        if (lowercaseGuess === lowercaseQuery) {
            document.getElementById('guesses').value = '';
            document.getElementById('number_loaded').value = '';
            all_images = '';
            guesses += 1;
            let score = 101 - guesses * load_more;
            if (score < 0) {
                score = 0;
            }

            // Call the updateScore function here
            updateScore(score);  // Send the score to PHP for updating
    
            document.getElementById('pics').innerHTML = `
                <div id="message">
                    <h2>"You're making excellent progress!"<br> The word is "${query}"</h2>
                    <p>Guesses: &nbsp; ${guesses}</p>
                    <p>Pictures Loaded: &nbsp; ${load_more}</p>
                    <p>Score: &nbsp; ${score}</p>
                    <p>Let's Play Again 😂</p>
                    <button class="button play-button" onclick="play()">Play Again 🙌</button>
                    <button class="button quit-button" onclick="quit()">Quit Game 🙀</button>
                </div>
            `;
            document.getElementById('showMore').style.display = 'none';
            document.getElementById('giveUp').style.display = 'none';
            document.getElementById('guess_field').value = 'Click Play Again';
            guesses = 0;
            load_more = 1;
            query = ""; // Reset the query word
        } else {
            guesses += 1;
            document.getElementById('guesses').value = 'Guesses Made: ' + guesses;
            document.getElementById('guess').elements['guess'].setAttribute('placeholder', 'Please Try Again');
            document.getElementById('guess').elements['guess'].value = '';
        }
    }
}

function giveUp_function() {
    document.getElementById('guesses').value = '';
    document.getElementById('number_loaded').value = '';
    all_images = '';
  
    document.getElementById('pics').innerHTML = `
        <div id="message">
            <h2>"You Are Getting Closer!"<br> The word is "${query}"</h2>
            <p>Guesses: &nbsp; ${guesses}</p>
            <p>Pictures Loaded: &nbsp; ${load_more}</p>
            <p>Score: 0</p>
            <p>Let's Play Again 😝</p>
            <button class="button play-button" onclick="play()">Play Again 😍</button>
            <button class="button quit-button" onclick="quit()">Quit Game 🙀</button>
        </div>
    `;
  
    guesses = 0;
    load_more = 1;
    document.getElementById('showMore').style.display = 'none';
    document.getElementById('giveUp').style.display = 'none';
    document.getElementById('guess_field').value = '';
  
    updateScore(0);  // Send 0 score to PHP
}

// Debugging the sessionStorage for guest user
console.log("Guest ID:", sessionStorage.getItem('guest_id'));

  




/* Start Of Loading Screen Animation */
// Show the loading screen when the page starts loading
window.addEventListener('load', function () {
  const loadingScreen = document.getElementById('loading-screen');
  loadingScreen.style.display = 'flex'; // Ensure it's visible
});

// Hide the loading screen when the page has finished loading
window.addEventListener('DOMContentLoaded', function () {
  const loadingScreen = document.getElementById('loading-screen');
  // Add a delay before hiding the loading screen (e.g., 500 milliseconds)
  setTimeout(function() {
    loadingScreen.style.display = 'none';
  }, 1500);
}); /* End Of Loading Screen Animation */





