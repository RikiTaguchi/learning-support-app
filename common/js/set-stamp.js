window.addEventListener('load', () => {
    const form = document.querySelector('.form');
    const formNormal = document.querySelector('.form-normal');
    const formRandom = document.querySelector('.form-random');
    const radioNormal = document.querySelector('.radio-normal');
    const radioRandom = document.querySelector('.radio-random');
    const randomArea = Array.from(document.getElementsByClassName('random-area'));
    const randomBack = document.querySelector('.random-panel-back');
    const randomNext = document.querySelector('.random-panel-next');
    const countBlock = Array.from(document.getElementsByClassName('count-block'));
    const pageCount = document.querySelector('.page-count');
    const buttonAdd = document.querySelector('.set-add');
    const buttonRemove = document.querySelector('.set-remove');
    const fileNormal = document.querySelector('.file-normal');
    const fileRandom = Array.from(document.getElementsByClassName('file-random'));
    const probRandom = Array.from(document.getElementsByClassName('prob-random'));
    const buttonNormal = document.querySelector('.button-normal');
    const buttonRandom = Array.from(document.getElementsByClassName('button-random'));
    const previewNormal = document.querySelector('.preview-normal');
    const previewRandom = Array.from(document.getElementsByClassName('preview-random'));
    const submitButton = document.querySelector('.stamp-submit');

    // タイプ切替
    radioNormal.addEventListener('click', () => {
        formNormal.style.display = 'flex';
        formRandom.style.display = 'none';
        pageCount.value = '0';
        randomArea[0].style.display = 'flex';
        countBlock[0].style.display = 'block';
        countBlock[0].style.backgroundColor = 'rgb(0, 129, 204)';
        randomArea[1].style.display = 'none';
        countBlock[1].style.display = 'block';
        countBlock[1].style.backgroundColor = 'lightgray';
        for (let i = 2; i < 5; i++) {
            randomArea[i].style.display = 'none';
            countBlock[i].style.display = 'none';
            countBlock[i].style.backgroundColor = 'lightgray';
        }
        fileNormal.setAttribute('required', true);
        previewNormal.src = '../common/images/preview-back.png';
        fileNormal.value = '';
        for (let i = 0; i < 5; i++) {
            fileRandom[i].removeAttribute('required');
            probRandom[i].removeAttribute('required');
            previewRandom[i].src = '../common/images/preview-back.png';
            fileRandom[i].value = '';
            probRandom[i].value = '';
        }
    });
    radioRandom.addEventListener('click', () => {
        formNormal.style.display = 'none';
        formRandom.style.display = 'flex';
        pageCount.value = '2';
        randomArea[0].style.display = 'flex';
        countBlock[0].style.display = 'block';
        countBlock[0].style.backgroundColor = 'rgb(0, 129, 204)';
        randomArea[1].style.display = 'none';
        countBlock[1].style.display = 'block';
        countBlock[1].style.backgroundColor = 'lightgray';
        for (let i = 2; i < 5; i++) {
            randomArea[i].style.display = 'none';
            countBlock[i].style.display = 'none';
            countBlock[i].style.backgroundColor = 'lightgray';
        }
        fileNormal.removeAttribute('required');
        previewNormal.src = '../common/images/preview-back.png';
        fileNormal.value = '';
        fileRandom[0].setAttribute('required', true);
        probRandom[0].setAttribute('required', true);
        previewRandom[0].src = '../common/images/preview-back.png';
        fileRandom[0].value = '';
        probRandom[0].value = '';
        fileRandom[1].setAttribute('required', true);
        probRandom[1].setAttribute('required', true);
        previewRandom[1].src = '../common/images/preview-back.png';
        fileRandom[1].value = '';
        probRandom[1].value = '';
        for (let i = 2; i < 5; i++) {
            fileRandom[i].removeAttribute('required');
            probRandom[i].removeAttribute('required');
            previewRandom[i].src = '../common/images/preview-back.png';
            fileRandom[i].value = '';
            probRandom[i].value = '';
        }
    });

    // ページ切替
    randomBack.addEventListener('click', () => {
        let page;
        let count = parseInt(pageCount.value, 10);
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
                    countBlock[i].style.backgroundColor = 'rgb(0, 129, 204)';
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
                    countBlock[i].style.backgroundColor = 'rgb(0, 129, 204)';
                } else {
                    countBlock[i].style.backgroundColor = 'lightgray';
                }
            }
        }
    });

    // ページ追加・削除
    buttonAdd.addEventListener('click', () => {
        let page;
        let count = parseInt(pageCount.value, 10);
        for (let i = 0; i < count; i++) {
            if (randomArea[i].style.display === 'flex') {
                page = i;
                break;
            }
        }
        if (count < 5) {
            count++;
            pageCount.value = count;
            for (let i = 0; i < count; i++) {
                countBlock[i].style.display = 'block';
                if (i === page) {
                    countBlock[i].style.backgroundColor = 'rgb(0, 129, 204)';
                } else {
                    countBlock[i].style.backgroundColor = 'lightgray';
                }
            }
            fileRandom[count - 1].setAttribute('required', true);
            probRandom[count - 1].setAttribute('required', true);
            previewRandom[count - 1].src = '../common/images/preview-back.png';
            fileRandom[count - 1] .value = '';
            probRandom[count - 1].value = '';
        }
    });
    buttonRemove.addEventListener('click', () => {
        let page;
        let count = parseInt(pageCount.value, 10);
        for (let i = 0; i < count; i++) {
            if (randomArea[i].style.display === 'flex') {
                page = i;
                break;
            }
        }
        if (count > 2) {
            count--;
            pageCount.value = count;
            if (page === count) {
                page--;
                randomArea[page].style.display = 'flex';
                randomArea[page + 1].style.display = 'none';
            }
            for (let i = 0; i < count; i++) {
                if (i === page) {
                    countBlock[i].style.backgroundColor = 'rgb(0, 129, 204)';
                } else {
                    countBlock[i].style.backgroundColor = 'lightgray';
                }
            }
            for (let i = count; i < 5; i++) {
                countBlock[i].style.display = 'none';
            }
            fileRandom[count].removeAttribute('required');
            probRandom[count].removeAttribute('required');
            previewRandom[count].src = '../common/images/preview-back.png';
            fileRandom[count].value = '';
            probRandom[count].value = '';
        }
    });

    // ファイル選択
    buttonNormal.addEventListener('click', () => {
        fileNormal.click();
    });
    for (let i = 0; i < 5; i++) {
        buttonRandom[i].addEventListener('click', () => {
            fileRandom[i].click();
        });
    }

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
    for (let i = 0; i < 5; i++) {
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

    // 送信時チェック
    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        let count = parseInt(pageCount.value, 10);
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
