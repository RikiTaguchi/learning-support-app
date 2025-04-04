window.addEventListener('load', () => {
    const stampArea = document.querySelector('.main-stamp-area');
    stampArea.scrollTop = stampArea.scrollHeight;

    const checkStamp = document.querySelector('.main-stamp-detail-get');
    const newStamp = document.querySelector('.main-stamp-button' + document.querySelector('.stamp-last-number').textContent);

    const getEffect = {
        transform: ['rotate3d(0, 1, 0, -720deg) scale(1, 1)', 'rotate3d(0, 1, 0, -540deg) scale(2, 2)', 'rotate3d(0, 1, 0, -360deg) scale(2, 2)', 'rotate3d(0, 1, 0, -180deg) scale(2, 2)', 'rotate3d(0, 1, 0, 0deg) scale(1, 1)'],
    };
    const options = {
        duration: 1000,
        easing: 'ease',
        fill: 'forwards',
    };

    if (checkStamp.textContent === 'new') {
        newStamp.animate(getEffect, options);
    }
});
