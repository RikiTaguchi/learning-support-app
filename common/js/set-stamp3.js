window.addEventListener('load', () => {
    const detailButton = Array.from(document.getElementsByClassName('stamp-button-detail'));
    const stampBlock = Array.from(document.getElementsByClassName('stamp-block'));
    const qrOpenButton = Array.from(document.getElementsByClassName('stamp-button-qr'));
    const qrBlock = Array.from(document.getElementsByClassName('qr-block'));
    const qrCloseButton = Array.from(document.getElementsByClassName('qr-close'));
    const stampImage = Array.from(document.getElementsByClassName('stamp-block-img'));

    for (let i = 0; i < detailButton.length; i++) {
        // 詳細の表示・非表示切替
        detailButton[i].addEventListener('click', () => {
            if (stampBlock[i].style.display === 'none') {
                stampBlock[i].style.display = 'flex';
            } else {
                stampBlock[i].style.display = 'none';
            }
        });

        // QRコードの表示
        qrOpenButton[i].addEventListener('click', () => {
            qrBlock[i].style.display = 'flex';
        });

        // QRコードの非表示
        qrCloseButton[i].addEventListener('click', () => {
            qrBlock[i].style.display = 'none';
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
