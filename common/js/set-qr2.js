window.addEventListener('load', () => {
    const stampButton = document.querySelector('.main-form-qr-button');
    stampButton.addEventListener('click', () => {
        stampButton.disabled = true;
    });
});
