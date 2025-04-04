window.addEventListener('load', () => {
    const bannerArea = document.querySelector('.main-banner');
    const bannerMessage = document.querySelector('.main-banner-text');

    const urlString = window.location.href;
    const url = new URL(urlString);
    const errorType = url.searchParams.get('banner');
    
    if (errorType === '10') {
        bannerMessage.textContent = 'このユーザーIDは既に使用されています。別のIDで登録してください。';
    }

    const options = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };

    const displayBanner = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    if (bannerMessage.textContent !== '') {
        bannerArea.animate(displayBanner, options);
    }
});