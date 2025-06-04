document.addEventListener('DOMContentLoaded', () => {
    const noticeButton = Array.from(document.getElementsByClassName('notice-button'));
    const noticeDetail = Array.from(document.getElementsByClassName('notice-detail'));

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const openDetail = {
        opacity: [0, 1],
        height: ['0%', '100%'],
    };

    for (let i = 0; i < noticeButton.length; i++) {
        noticeButton[i].addEventListener('click', () => {
            if (noticeDetail[i].style.display === 'none') {
                noticeDetail[i].style.display = 'block';
                noticeDetail[i].animate(openDetail, options);
            } else {
                noticeDetail[i].style.display = 'none';
            }
        });
    }
});
