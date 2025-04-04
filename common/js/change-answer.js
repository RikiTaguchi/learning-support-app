window.addEventListener('load', () => {
    const panel = document.querySelector('.main-block');
    const bookName = document.querySelector('.info-bookname').textContent;

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };

    const options2 = {
        duration: 3000,
        easing: 'ease',
        fill: 'forwards',
    };

    const slideAnswer = {
        transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const displayNotice = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    const infoFeedback = document.querySelector('.info-feedback-text').textContent;

    if (infoFeedback !== 'feedback') {
        if (bookName === 'Vintage' || bookName === '明光暗記テキスト(文法)') {
            panel.animate(slideAnswer, options);
        }
    } else {
        const buttonFeedback = document.querySelector('.btn-feedback').textContent;
        const noticeMessage = document.querySelector('.main-notice-feedback');
        const noticeMessageText = document.querySelector('.main-notice-feedback-text');

        if (buttonFeedback === '復習リストに追加') {
            noticeMessageText.textContent = '復習リストから削除しました。';
            noticeMessage.animate(displayNotice, options2);
        } else if (buttonFeedback === '復習リストから削除') {
            noticeMessageText.textContent = '復習リストに追加しました。';
            noticeMessage.animate(displayNotice, options2);
        } else if (buttonFeedback === '復習リストから削除済') {
            noticeMessageText.textContent = '復習リストから削除しました。';
            noticeMessage.animate(displayNotice, options2);
        }
    }
});
