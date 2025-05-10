document.addEventListener('DOMContentLoaded', () => {
    const noticeButton = Array.from(document.getElementsByClassName('notice-button'));
    const noticeDetail = Array.from(document.getElementsByClassName('notice-detail'));

    for (let i = 0; i < noticeButton.length; i++) {
        noticeButton[i].addEventListener('click', () => {
            if (noticeDetail[i].style.display === 'none') {
                noticeDetail[i].style.display = 'block';
            } else {
                noticeDetail[i].style.display = 'none';
            }
        });
    }
});
