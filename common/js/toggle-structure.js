window.addEventListener('load', () => {
    const howtoButton = document.querySelector('.button-howto');
    const howtoList = document.querySelector('.block-howto');
    howtoButton.addEventListener('click', () => {
        if (howtoList.style.display === 'none') {
            howtoList.style.display = 'block';
        } else {
            howtoList.style.display = 'none';
        }
    });
});
