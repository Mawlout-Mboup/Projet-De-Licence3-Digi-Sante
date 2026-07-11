document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.getAttribute('data-password-toggle'));

            if (target instanceof HTMLInputElement) {
                target.type = target.type === 'password' ? 'text' : 'password';
            }
        });
    });
});
