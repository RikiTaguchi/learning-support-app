window.addEventListener('load', () => {
    const menuButton = document.querySelector('.header-menu-button');
    const menu = document.querySelector('.header-site-menu');
    const menuInfo = document.querySelector('.header-menu-info');

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const menuOpen = {
        translate: ['0 -100%', '0 0'],
    };

    const menuClose = {
        translate: ['0 0', '0 -100%'],
    };

    menuButton.addEventListener('click', () => {
        if (menuInfo.textContent === 'closed') {
            menu.animate(menuOpen, options);
            menuInfo.textContent = 'opend';
        } else {
            menu.animate(menuClose, options);
            menuInfo.textContent = 'closed';
        }
    });
});
