const passwordInputs = document.querySelectorAll('.password-input');
const checkbox = document.getElementById("showPassword");

checkbox.addEventListener('change', () => {
    passwordInputs.forEach((input) => {
        input.type = checkbox.checked ? 'text' : 'password';
    });
});