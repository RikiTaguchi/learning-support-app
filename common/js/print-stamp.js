document.addEventListener('DOMContentLoaded', () => {
    const printButton = Array.from(document.getElementsByClassName('qr-print'));
    const printArea = Array.from(document.getElementsByClassName('print-area'));

    for (let i = 0; i < printButton.length; i++) {
        printButton[i].addEventListener('click', () => {
            for (let j = 0; j < printButton.length; j++) {
                if (i !== j) {
                    // 非表示
                    printArea[j].classList.remove('print-target');
                } else {
                    // 表示
                    printArea[j].classList.add('print-target');

                    // 画像の読み込み
                    const printImageList = Array.from(printArea[i].getElementsByTagName('img'));
                    for (let k = 0; k < printImageList.length; k++) {
                        printImageList[k].src = printImageList[k].dataset.src;
                    }

                    // 印刷
                    let loadedCount = 0;
                    for (let k = 0; k < printImageList.length; k++) {
                        if (printImageList[k].complete) {
                            loadedCount += 1;
                        } else {
                            printImageList[k].addEventListener('load', () => {
                                loadedCount++;
                                if (loadedCount === printImageList.length) {
                                    window.print();
                                }
                            });
                        }
                    }
                    if (loadedCount === printImageList.length) {
                        window.print();
                    }
                }
            }
        });
    }
});
