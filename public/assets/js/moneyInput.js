const moneyInputs = document.querySelectorAll('.money-input');

const currencyFormatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
});

moneyInputs.forEach((input) => {
    input.addEventListener('input', (event) => {
        const digits = event.target.value.replace(/\D/g, '');

        if (!digits) {
            event.target.value = '';
            return;
        }

        const amount = Number(digits) / 100;

        event.target.value = currencyFormatter.format(amount);
    });
});