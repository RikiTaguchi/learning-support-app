window.addEventListener('load', () => {
    const printButton = Array.from(document.getElementsByClassName('qr-print'));
    const printArea = Array.from(document.getElementsByClassName('print-area'));

    for (let i = 0; i < printButton.length; i++) {
        printButton[i].addEventListener('click', () => {
            for (let j = 0; j < printButton.length; j++) {
                if (i !== j) {
                    printArea[j].classList.remove('print-target');
                } else {
                    printArea[j].classList.add('print-target');
                }
            }
            window.print();
        });
    }
});
