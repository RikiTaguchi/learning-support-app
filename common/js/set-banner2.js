window.addEventListener('load', () => {
    const bannerArea = document.querySelector('.main-banner');
    const bannerMessage = document.querySelector('.main-banner-text');

    const urlString = window.location.href;
    const url = new URL(urlString);
    const errorType = url.searchParams.get('banner');
    
    if (errorType === '0') {
        bannerMessage.textContent = '未登録のアカウントです。入力内容にミスがないか確認してしてください。';
    } else if (errorType === '1') {
        bannerMessage.textContent = 'パスワードが違います。入力内容にミスがないか確認してしてください。';
    } else if (errorType === '2') {
        bannerMessage.textContent = 'データベースとの接続に失敗しました。もう一度ログインしてください。';
    } else if (errorType === '6') {
        bannerMessage.textContent = 'ログアウトが完了しました。';
    } else if (errorType === '13') {
        bannerMessage.textContent = '予期せぬエラーが発生しました。もう一度ログインしてください。';
    } else if (errorType === '14') {
        bannerMessage.textContent = '登録が完了しました。';
    } else if (errorType === '15') {
        bannerMessage.textContent = '削除が完了しました。';
    } else if (errorType === '41') {
        bannerMessage.textContent = 'スタンプの取得にはログインが必要です。';
    }

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
