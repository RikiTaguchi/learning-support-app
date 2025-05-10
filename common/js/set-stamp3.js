document.addEventListener('DOMContentLoaded', () => {
    const detailButton = Array.from(document.getElementsByClassName('stamp-button-detail'));
    const stampBlock = Array.from(document.getElementsByClassName('stamp-block'));
    const qrOpenButton = Array.from(document.getElementsByClassName('stamp-button-qr'));
    const qrBlock = Array.from(document.getElementsByClassName('qr-block'));
    const qrCloseButton = Array.from(document.getElementsByClassName('qr-close'));
    const stampImage = Array.from(document.getElementsByClassName('stamp-block-img'));

    const options = {
        duration: 500,
        easing: 'ease',
        fill: 'forwards',
    };
    const openDetail = {
        translate: ['-50% -50%', '-50% -50%'],
        transform: ['rotate3d(0, 1, 0, 180deg)', 'rotate3d(0, 1, 0, 0deg)'],
        opacity: [0, 1],
    };
    const closeDetail = {
        translate: ['-50% -50%', '-50% -50%'],
        transform: ['rotate3d(0, 1, 0, -180deg)', 'rotate3d(0, 1, 0, 0deg)'],
        opacity: [1, 0],
    };

    for (let i = 0; i < detailButton.length; i++) {
        // 詳細の表示・非表示切替
        detailButton[i].addEventListener('click', () => {
            if (stampBlock[i].style.display === 'none') {
                // 表示
                stampBlock[i].style.display = 'flex';

                // 画像の読み込み
                const stampImageList = Array.from(stampImage[i].getElementsByTagName('img'));
                for (let j = 0; j < stampImageList.length; j++) {
                    stampImageList[j].src = stampImageList[j].dataset.src;
                }
            } else {
                stampBlock[i].style.display = 'none';
            }
        });

        // QRコードの表示
        qrOpenButton[i].addEventListener('click', () => {
            // 表示
            qrBlock[i].style.display = 'flex';
            qrBlock[i].animate(openDetail, options);

            // 画像の読み込み
            const qrImageList = Array.from(qrBlock[i].getElementsByTagName('img'));
            for (let j = 0; j < qrImageList.length; j++) {
                qrImageList[j].src = qrImageList[j].dataset.src;
            }
        });

        // QRコードの非表示
        qrCloseButton[i].addEventListener('click', () => {
            qrBlock[i].animate(closeDetail, options);
            setTimeout(() => {
                qrBlock[i].style.display = 'none';
            }, '500');
        });

        // スライド（タイプ：ランダム）
        if (stampImage[i].querySelector('div') !== null) {
            const leftButton = stampImage[i].querySelector('.stamp-block-left');
            const rightButton = stampImage[i].querySelector('.stamp-block-right');
            const stampList = Array.from(stampImage[i].querySelector('div').getElementsByClassName('stamp-panel'));
            const countBlock = Array.from(stampBlock[i].querySelector('.stamp-count').getElementsByClassName('count-block'));
            const pageCount = stampList.length;

            // パネル切替
            leftButton.addEventListener('click', () => {
                let pageTarget = 0;
                for (let j = 0; j < pageCount; j++) {
                    if (stampList[j].style.display === 'flex') {
                        pageTarget = j;
                        break;
                    }
                }
                if (pageTarget > 0) {
                    countBlock[pageTarget].style.backgroundColor = 'lightgray';
                    stampList[pageTarget].style.display = 'none';
                    countBlock[pageTarget - 1].style.backgroundColor = 'rgb(0, 149, 224)';
                    stampList[pageTarget - 1].style.display = 'flex';
                }
            });
            rightButton.addEventListener('click', () => {
                let pageTarget = 0;
                for (let j = 0; j < pageCount; j++) {
                    if (stampList[j].style.display === 'flex') {
                        pageTarget = j;
                        break;
                    }
                }
                if (pageTarget < pageCount - 1) {
                    countBlock[pageTarget].style.backgroundColor = 'lightgray';
                    stampList[pageTarget].style.display = 'none';
                    countBlock[pageTarget + 1].style.backgroundColor = 'rgb(0, 149, 224)';
                    stampList[pageTarget + 1].style.display = 'flex';
                }
            });
        }
    }
});
