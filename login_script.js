// Dummy credentials
const dummyCredentials = {
    username: 'user@gmail.com',
    password: 'password12'
};

// Toggle Menu Function
function myMenuFunction() {
    var menu = document.getElementById("navMenu");
    if (menu.className === "nav-menu") {
        menu.className += " responsive";
    } else {
        menu.className = "nav-menu";
    }
}

// Login Function
function login() {
    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");
    var loginForm = document.getElementById("login");
    var registerForm = document.getElementById("register");

    loginForm.style.left = "4px";
    registerForm.style.right = "-520px";
    loginBtn.classList.add("white-btn");
    registerBtn.classList.remove("white-btn");
    loginForm.style.opacity = 1;
    registerForm.style.opacity = 0;
}

// Register Function
function register() {
    var loginBtn = document.getElementById("loginBtn");
    var registerBtn = document.getElementById("registerBtn");
    var loginForm = document.getElementById("login");
    var registerForm = document.getElementById("register");

    loginForm.style.left = "-510px";
    registerForm.style.right = "5px";
    loginBtn.classList.remove("white-btn");
    registerBtn.classList.add("white-btn");
    loginForm.style.opacity = 0;
    registerForm.style.opacity = 1;
}

// Validate Login Form
function validateLoginForm() {
    var username = document.querySelector("#login .input-field[name='username']").value;
    var password = document.querySelector("#login .input-field[name='password']").value;
    var errorMessage = '';

    if (!username || !password) {
        errorMessage = 'Username and password are required.';
    } else if (password.length < 8) {
        errorMessage = 'Password must be at least 8 characters long.';
    }

    displayError('loginError', errorMessage);
    return !errorMessage;
}

// Validate Registration Form
function validateRegisterForm() {
    var firstName = document.querySelector("#register .input-field[name='firstname']").value;
    var lastName = document.querySelector("#register .input-field[name='lastname']").value;
    var email = document.querySelector("#register .input-field[name='email']").value;
    var password = document.querySelector("#register .input-field[name='password']").value;
    var errorMessage = '';

    if (!firstName || !lastName || !email || !password) {
        errorMessage = 'All fields are required.';
    } else if (!validateEmail(email)) {
        errorMessage = 'Invalid email address.';
    } else if (password.length < 8) {
        errorMessage = 'Password must be at least 8 characters long.';
    }

    displayError('registerError', errorMessage);
    return !errorMessage;
}

// Validate Email Function
function validateEmail(email) {
    var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}

// Display Error Messages
function displayError(elementId, message) {
    const errorElement = document.getElementById(elementId);
    if (errorElement) {
        errorElement.textContent = message;
    }
}

// Toggle Password Visibility
function togglePasswordVisibility(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleButton = document.getElementById(toggleId);

    toggleButton.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            toggleButton.textContent = "Show";
        }
    });
}

// Initialize toggle functionality
document.addEventListener("DOMContentLoaded", function() {
    togglePasswordVisibility("loginPassword", "loginTogglePassword");
    togglePasswordVisibility("registerPassword", "registerTogglePassword");
});

// Form Submission Handling
document.querySelector("#login .submit").addEventListener("click", function(event) {
    if (!validateLoginForm()) {
        event.preventDefault();
    } else {
        loginUser();
    }
});

document.querySelector("#register .submit").addEventListener("click", function(event) {
    if (!validateRegisterForm()) {
        event.preventDefault();
    } else {
        registerUser();
    }
});

// Login User Function
function loginUser() {
    const username = document.querySelector("#login .input-field[name='username']").value;
    const password = document.querySelector("#login .input-field[name='password']").value;

    if (username === dummyCredentials.username && password === dummyCredentials.password) {
        alert('Login successful!');
        // Redirect or handle successful login
    } else {
        alert('Invalid username or password.');
    }
}

// Register User Function
function registerUser() {
    const firstName = document.querySelector("#register .input-field[name='firstname']").value;
    const lastName = document.querySelector("#register .input-field[name='lastname']").value;
    const email = document.querySelector("#register .input-field[name='email']").value;
    const password = document.querySelector("#register .input-field[name='password']").value;

    // Simulate successful registration
    alert(`Registration successful! Welcome, ${firstName} ${lastName}.`);
    // Optionally, reset form fields
    resetRegisterForm();
}

// Reset Login Form
function resetLoginForm() {
    document.querySelector("#login .input-field[name='username']").value = '';
    document.querySelector("#login .input-field[name='password']").value = '';
}

// Reset Registration Form
function resetRegisterForm() {
    document.querySelector("#register .input-field[name='firstname']").value = '';
    document.querySelector("#register .input-field[name='lastname']").value = '';
    document.querySelector("#register .input-field[name='email']").value = '';
    document.querySelector("#register .input-field[name='password']").value = '';
}