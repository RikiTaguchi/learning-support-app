window.addEventListener('load', () => {
    const form = document.querySelector('.form');
    const randomArea = Array.from(document.getElementsByClassName('random-area'));
    const randomBack = document.querySelector('.random-panel-back');
    const randomNext = document.querySelector('.random-panel-next');
    const countBlock = Array.from(document.getElementsByClassName('count-block'));
    const pageCount = document.querySelector('.page-count');
    const count = parseInt(pageCount.value, 10);
    const fileNormal = document.querySelector('.file-normal');
    const fileRandom = Array.from(document.getElementsByClassName('file-random'));
    const probRandom = Array.from(document.getElementsByClassName('prob-random'));
    const buttonNormal = document.querySelector('.button-normal');
    const buttonRandom = Array.from(document.getElementsByClassName('button-random'));
    const previewNormal = document.querySelector('.preview-normal');
    const previewRandom = Array.from(document.getElementsByClassName('preview-random'));
    const submitButton = document.querySelector('.stamp-submit');

    if (count === 0) { // 通常
        // ファイル選択
        buttonNormal.addEventListener('click', () => {
            fileNormal.click();
        });

        // プレビュー更新
        fileNormal.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewNormal.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    } else { // ランダム
        // ページ切替
        randomBack.addEventListener('click', () => {
            let page;
            for (let i = 0; i < count; i++) {
                if (randomArea[i].style.display === 'flex') {
                    page = i;
                    break;
                }
            }
            if (page !== 0) {
                randomArea[page].style.display = 'none';
                randomArea[page - 1].style.display = 'flex';
                for (let i = 0; i < count; i++) {
                    if (i === page - 1) {
                        countBlock[i].style.backgroundColor = 'lightseagreen';
                    } else {
                        countBlock[i].style.backgroundColor = 'lightgray';
                    }
                }
            }
        });
        randomNext.addEventListener('click', () => {
            let page;
            let count = parseInt(pageCount.value, 10);
            for (let i = 0; i < count; i++) {
                if (randomArea[i].style.display === 'flex') {
                    page = i;
                    break;
                }
            }
            if (page !== count - 1) {
                randomArea[page].style.display = 'none';
                randomArea[page + 1].style.display = 'flex';
                for (let i = 0; i < count; i++) {
                    if (i === page + 1) {
                        countBlock[i].style.backgroundColor = 'lightseagreen';
                    } else {
                        countBlock[i].style.backgroundColor = 'lightgray';
                    }
                }
            }
        });

        // ファイル選択
        for (let i = 0; i < count; i++) {
            buttonRandom[i].addEventListener('click', () => {
                fileRandom[i].click();
            });
        }

        // プレビュー更新
        for (let i = 0; i < count; i++) {
            fileRandom[i].addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewRandom[i].src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // 送信時チェック
    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        const requiredInputs = form.querySelectorAll('input[required]');
        const allFilled = Array.from(requiredInputs).every(input => input.value.trim() !== '');
        if (count === 0) {
            if (allFilled) {
                form.submit();
            } else {
                alert('未入力の項目があります。');
            }
        } else {
            if (allFilled) {
                let probSum = 0;
                for (let i = 0; i < count; i++) {
                    let prob = Number(probRandom[i].value);
                    if (probRandom[i].value === '' || !Number.isInteger(prob)) {
                        break;
                    } else {
                        probSum += prob;
                    }
                }
                if (probSum === 100) {
                    form.submit();
                } else {
                    alert('確率は整数値で、合計が100になるように設定してください。');
                }
            } else {
                alert('未入力の項目があります。');
            }
        }
    });
});
