const form = document.getElementById('submit-form');
const button = form.querySelector('[type="submit"]');

let submitting = false;

form.addEventListener('submit', (event) => {
    if (submitting) {
        event.preventDefault();
        return;
    }

    submitting = true;
    button.disabled = true;
    button.textContent = 'Registrando...';
});