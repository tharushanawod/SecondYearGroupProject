const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

document.addEventListener('DOMContentLoaded', () => {
  const signInForm = document.getElementById('sign-in-form');
  const signUpForm = document.getElementById('sign-up-form');

  signInForm.addEventListener('submit', (event) => {
    if (!validateSignInForm()) {
      event.preventDefault();
    }
  });

  signUpForm.addEventListener('submit', (event) => {
    if (!validateSignUpForm()) {
      event.preventDefault();
    }
  });

  function validateSignInForm() {
    const email = signInForm.querySelector('input[name="email"]');
    const password = signInForm.querySelector('input[name="password"]');
    let valid = true;

    if (!validateEmail(email.value)) {
      showError(email, 'Invalid email address');
      valid = false;
    } else {
      clearError(email);
    }

    if (password.value.trim() === '') {
      showError(password, 'Password is required');
      valid = false;
    } else {
      clearError(password);
    }

    return valid;
  }

  function validateSignUpForm() {
    const email = signUpForm.querySelector('input[name="email"]');
    const password = signUpForm.querySelector('input[name="password"]');
    const confirmPassword = signUpForm.querySelector('input[name="confirm-password"]');
    let valid = true;

    if (!validateEmail(email.value)) {
      showError(email, 'Invalid email address');
      valid = false;
    } else {
      clearError(email);
    }

    if (password.value.trim() === '') {
      showError(password, 'Password is required');
      valid = false;
    } else {
      clearError(password);
    }

    if (password.value !== confirmPassword.value) {
      showError(confirmPassword, 'Passwords do not match');
      valid = false;
    } else {
      clearError(confirmPassword);
    }

    return valid;
  }

  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
  }

  function showError(input, message) {
    const errorElement = document.createElement('span');
    errorElement.className = 'error-message';
    errorElement.innerText = message;
    input.parentElement.appendChild(errorElement);
    input.classList.add('error');
  }

  function clearError(input) {
    const errorElement = input.parentElement.querySelector('.error-message');
    if (errorElement) {
      errorElement.remove();
    }
    input.classList.remove('error');
  }
});