document.querySelector(".button1").addEventListener("click", function (e) {
    e.preventDefault();

    let username = document.querySelector("input[placeholder='Username']").value.trim();
    let password = document.querySelector("input[placeholder='Password']").value.trim();

    if (username === "" || password === "") {
        alert("Please enter both username and password.");
        return;
    }

    fetch("includes/login.php", {
        method: "POST",
        body: new URLSearchParams({ username, password }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
    })
    .then(response => response.text())
    .then(data => {
        // Debugging: Log the raw response data
        console.log("Raw server response:", data);

        // Check for success
        if (data.trim() === "success") {
            console.log("Login successful. Redirecting...");
            window.location.href = "includes/home.php";
        } else {
            // Log failed data and response, and include it in the alert
            console.error("Login failed! Data:", data);
            alert("Login failed! Error: " + data);  // Show server response in the alert
        }
    })
    .catch(error => {
        console.error("Error:", error);  // Catch network issues or fetch errors
        alert("Something went wrong. Error: " + error);  // Show network error in the alert
    });
});




/* old code for registration, catches input from login form and interacts with server directly
document.querySelector(".button2").addEventListener("click", function (e) {
    e.preventDefault();
    let username = document.querySelector("input[placeholder='Username']").value;
    let password = document.querySelector("input[placeholder='Password']").value;

    fetch("register.php", {
        method: "POST",
        body: new URLSearchParams({ username, password }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            alert("Registration successful! You can now log in.");
        } else {
            alert("Registration failed.");
        }
    });
});*/

/*
// Event listener for the "Sign Up" button
// Loads the registration form below the login form without refreshing the entire page
document.getElementById('signupButton').addEventListener('click', function() {
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Open a GET request to the registration form URL
    xhr.open('GET', 'includes/registration.php', true); // 'registrationForm.html' should be the URL of the registration form

    // Set up the callback function to handle the response
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Insert the response HTML (registration form) into the container
            document.getElementById('registrationContainer').innerHTML = xhr.responseText;
        } else {
            // Handle error
            alert('Failed to load registration form');
        }
    };

    // Send the request
    xhr.send();
});
*/


//Updated JavaScript (for toggling password visibility):
// Toggle password visibility
document.getElementById('eyeIcon').addEventListener('click', function() {
    var passwordField = document.getElementById('passwordField');
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; // Show password
        document.getElementById('eyeIcon').style.color = "#2d2d2d"; // Change icon color to indicate visible password
    } else {
        passwordField.type = 'password'; // Hide password
        document.getElementById('eyeIcon').style.color = "#4b4b4b"; // Reset icon color
    }
});




//Data Validation Codes - Registration.php 
document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.querySelector('input[placeholder="Username"]');
    const firstNameInput = document.querySelector('input[placeholder="First Name"]');
    const lastNameInput = document.querySelector('input[placeholder="Last Name"]');
    const emailInput = document.querySelector('input[placeholder="Email"]');
    const passwordInput = document.querySelector('#passwordField');
    const submitButton = document.querySelector('#submitButton');

    // Function to validate if a field is empty
    function isNotEmpty(input) {
        if (input.value.trim() === "") {
            input.placeholder = "This field cannot be empty";
            return false;
        }
        input.placeholder = "";  // Reset placeholder if valid
        return true;
    }

    // Function to restrict numbers in First Name and Last Name fields
    function restrictNumbers(input) {
        input.addEventListener('input', function(e) {
            // Remove numbers from the input value
            input.value = input.value.replace(/[0-9]/g, '');
        });
    }

    // Function to validate email
    function validateEmail() {
        const email = emailInput.value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        
        if (!emailPattern.test(email)) {
            // Display error if email is invalid
            emailInput.setCustomValidity("Please enter a valid email address.");
            emailInput.reportValidity(); // Triggers the browser's validation UI
            return false;
        } else {
            // Clear any previous error if email is valid
            emailInput.setCustomValidity("");  // Clear custom validity
            return true;
        }
    }

    // Function to validate password
    function validatePassword() {
        const password = passwordInput.value;
        if (password.length < 6) {
            passwordInput.placeholder = "Password must be at least 6 characters";
            return false;
        }
        passwordInput.placeholder = "";  // Reset placeholder if valid
        return true;
    }

    // Function to validate First Name and Last Name fields
    function validateNames() {
        const isFirstNameValid = isNotEmpty(firstNameInput);
        const isLastNameValid = isNotEmpty(lastNameInput);
        return isFirstNameValid && isLastNameValid;
    }

    // Real-time validation for input fields
    firstNameInput.addEventListener('input', () => {
        isNotEmpty(firstNameInput);
        restrictNumbers(firstNameInput);
    });

    lastNameInput.addEventListener('input', () => {
        isNotEmpty(lastNameInput);
        restrictNumbers(lastNameInput);
    });

    emailInput.addEventListener('input', validateEmail); // Real-time email validation
    passwordInput.addEventListener('input', validatePassword);

    // Real-time validation for submit button
    submitButton.addEventListener('click', function(e) {
        let isFormValid = true;

        // Check if all fields are valid
        if (!isNotEmpty(usernameInput) || !validateNames() || !validateEmail() || !validatePassword()) {
            isFormValid = false;
        }

        // Prevent form submission if there are errors
        if (!isFormValid) {
            e.preventDefault();
        }
    });
});


//Registration Function
