window.addEventListener('load', () => {
    const panel = document.querySelector('.main-block');
    const bookName = document.querySelector('.info-bookname').textContent;
    const slideType = document.querySelector('.info-submit');

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

    const slideNext = {
        transform: ['rotate3d(1, 0, 0, 180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const slideBack = {
        transform: ['rotate3d(1, 0, 0, -180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const slideStart = {
        transform: ['rotate3d(1, 0, 0, 180deg)', 'rotate3d(1, 0, 0, 0deg)'],
    };

    const displayNotice = {
        translate: ['0 -100%', '0 20%', '0 20%', '0 20%', '0 20%', '0 20%', '0 -100%'],
        opacity: [0, 1, 1, 1, 1, 1, 0],
    };

    const infoFeedback = document.querySelector('.info-feedback-text').textContent;

    if (infoFeedback !== 'feedback') {
        if (bookName === 'Vintage' || bookName === '明光暗記テキスト(文法)') {
            const questionType = document.querySelector('.info-type').textContent;

            if (questionType === '2') {
                const orderSelected = document.querySelector('.main-inner-answer-menu-choices-order').textContent;

                if (orderSelected === '') {
                    panel.animate(slideStart, options);
                }
            } else {
                if (slideType.textContent === 'Next') {
                    panel.animate(slideNext, options);
                } else if (slideType.textContent === 'Back') {
                    panel.animate(slideBack, options);
                } else {
                    panel.animate(slideStart, options);
                }
            }
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
