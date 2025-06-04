document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.header-menu-button');
    const menu = document.querySelector('.header-site-menu');
    const menuInfo = document.querySelector('.header-menu-info');
    const menuTop = document.querySelector('.header-menu-top');
    const menuMiddle = document.querySelector('.header-menu-middle');
    const menuBottom = document.querySelector('.header-menu-bottom');
    const menuBack = document.querySelector('.menu-back');

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const menuOpen = {
        translate: ['110% 0', '0 0'],
    };

    const menuClose = {
        translate: ['0 0', '110% 0'],
    };

    // 回転用（top）
    const topOpen = {
        transform: ['rotate(0deg)', 'rotate(45deg)'],
        translate: ['0 0', '0 3px']
    };
    const topClose = {
        transform: ['rotate(45deg)', 'rotate(0deg)'],
        translate: ['0 3px', '0 0']
    };

    // 回転用（bottom）
    const bottomOpen = {
        transform: ['rotate(0deg)', 'rotate(-45deg)'],
        translate: ['0 0', '0 -3px']
    };
    const bottomClose = {
        transform: ['rotate(-45deg)', 'rotate(0deg)'],
        translate: ['0 -3px', '0 0']
    };

    menuButton.addEventListener('click', () => {
        if (menuInfo.textContent === 'closed') {
            menu.animate(menuOpen, options);
            menuTop.animate(topOpen, options);
            menuBottom.animate(bottomOpen, options);
            menuInfo.textContent = 'opend';
            menuMiddle.style.display = 'none';
            menuBack.style.display = 'block';
        } else {
            menu.animate(menuClose, options);
            menuTop.animate(topClose, options);
            menuBottom.animate(bottomClose, options);
            menuInfo.textContent = 'closed';
            menuMiddle.style.display = 'block';
            menuBack.style.display = 'none';
        }
    });

    menuBack.addEventListener('click', () => {
        menu.animate(menuClose, options);
        menuTop.animate(topClose, options);
        menuBottom.animate(bottomClose, options);
        menuInfo.textContent = 'closed';
        menuMiddle.style.display = 'block';
        menuBack.style.display = 'none';
    });
});
