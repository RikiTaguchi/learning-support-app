document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.index-button');
    const index = document.querySelector('.index-list');

    index.style.display = 'none';

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const openIndex = {
        opacity: [0, 1],
        height: ['0%', '100%'],
    };

    button.addEventListener('click', () => {
        if (index.style.display === 'none') {
            index.style.display = 'block';
            index.animate(openIndex, options);
        } else {
            index.style.display = 'none';
        }
    });
});
