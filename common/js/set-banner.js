window.addEventListener('load', () => {
    const bannerArea = document.querySelector('.main-banner');
    const bannerMessage = document.querySelector('.main-banner-text');

    const options = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };

    const displayBanner = {
        translate: ['0 0', '0 100%', '0 100%', '0 100%', '0 100%', '0 100%', '0 0'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    if (bannerMessage.textContent !== '') {
        bannerArea.animate(displayBanner, options);
    }
});
