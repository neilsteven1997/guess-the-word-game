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

// Data Validation - Registration Validation
document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.querySelector('input[placeholder="Username"]');
    const firstNameInput = document.querySelector('input[placeholder="First Name"]');
    const lastNameInput = document.querySelector('input[placeholder="Last Name"]');
    const emailInput = document.querySelector('input[placeholder="Email"]');
    const passwordInput = document.querySelector('#passwordField');
    const form = document.getElementById('registrationForm');

    // Function to validate if a field is empty
    function isNotEmpty(input) {
        if (input.value.trim() === "") {
            input.setCustomValidity("This field cannot be empty");
            return false;
        }
        input.setCustomValidity("");  // Reset custom validity if valid
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
            emailInput.setCustomValidity("Please enter a valid email address.");
            emailInput.reportValidity(); // Triggers the browser's validation UI
            return false;
        } else {
            emailInput.setCustomValidity("");  // Clear custom validity
            return true;
        }
    }

    // Function to validate password
    function validatePassword() {
        const password = passwordInput.value;
        if (password.length < 6) {
            passwordInput.setCustomValidity("Password must be at least 6 characters");
            return false;
        }
        passwordInput.setCustomValidity("");  // Reset custom validity if valid
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

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isFormValid = true;

        // Check if all fields are valid
        if (!isNotEmpty(usernameInput) || !validateNames() || !validateEmail() || !validatePassword()) {
            isFormValid = false;
        }

        // Prevent form submission if there are errors
        if (!isFormValid) {
            e.preventDefault();
            return false; // Ensure the form doesn't submit
        }
    });
});
